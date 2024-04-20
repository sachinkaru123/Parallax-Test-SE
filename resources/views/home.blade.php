@extends('inc.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header h3">Book List</div>

                    <div class="card-body">
                        <div class="row border p-3">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="book_name" class="h6">Select Categories</label>
                                    <select class="custom-select form-control" name="category" id="category">
                                        <option value="0">All</option>
                                        @foreach ($categories as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="book_name" class="h6">Search by Book Name: </label>
                                    <input type="text" class="form-control" name="search" id="search">
                                </div>
                            </div>
                        </div>

                        <div class="row mt-5">
                            <div class="col-md-10">
                                <table class="table">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Book Title</th>
                                            <th scope="col">Book Author</th>
                                            <th scope="col">Book category</th>
                                            <th scope="col">Stock</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Created At</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tbody id="bookListBody">

                                    </tbody>

                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
       

        <div class="modal" id="successModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title m-2" id="ModalLabel"></h5>
                        <button type="button" class="btn-close btn-danger" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modalBody">
                        Your request has been successfully saved. Further information will be sent to your email. Please
                        check
                        your emails for updates accordingly.
                        <br><br>
                        <b>Thank You</b>
                    </div>
                    <div class="modal-footer" id="modalfooter">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function() {


            // Other event handlers and functions remain unchanged
        });
    </script>
    <script>
        $(function() {

           

            var booksArr = {!! json_encode($books) !!}; //get data firn controller
            console.log(booksArr);
            createTableData(booksArr);

            $("#search").on("input", function() {
                var searchTerm = $(this).val().trim();
                if (searchTerm === "") {
                    createTableData(booksArr);
                }

                if (searchTerm.length >= 3) {

                    $.ajax({
                        url: "{{ route('search.books') }}",
                        data: {
                            term: searchTerm
                        },
                        dataType: "json",
                        success: function(data) {
                            createTableData(data);
                        }
                    });
                }
            });

            $("#category").change(function() {
                createTableData(booksArr);

            });

        });



        function createTableData(books) {

            var tableBody = $("#bookListBody");
            tableBody.empty();

            var category = $("#category").val().toString(); //conststn
            console.log(books.length);
            if (books.length === 0) {
                tableBody.append(`<div class="h3 text-center">No books found!</div>`);
            } else {
                for (var i = 0; i < books.length; i++) {
                    var row;
                    if (books[i].id === null) {
                        tableBody.append(`<div class="h3 text-center">No books found!</div>`);
                    }
                    // console.log(books[i].book_category_id === category);
                    // Check if the category is "All" or match
                    if (category === "0" || category == books[i].book_category_id) {

                        row = `
                <tr>
                    <th scope="row">${books[i].id}</th>
                    <td>${books[i].title}</td>
                    <td>${books[i].author}</td>
                    <td>${books[i].category_name}</td>
                    <td>${books[i].stock}</td>
                    <td>${books[i].price}</td>
                    <td>${books[i].created_at}</td>
                    <td class="d-flex">
                       <a href="/book/update/${books[i].id}"> <button type="button" class="btn btn-primary mx-3" onclick="">edit</button></a>
                       <button type="button" class="btn btn-danger" onclick="viewConfModel(${books[i].id}, '${books[i].title}')">Delete</button>

                        
                    </td>
                </tr>
            `;
                        tableBody.append(row);
                    }
                }
            }


        }

        //confirm modal
        function viewConfModel(id, name) {
            console.log(id);


            var modalBody = document.getElementById('modalBody');
            modalBody.innerHTML = `
            <p>Are you sure to delete this Book? 
            This action cannot be undone. This Will delete all the related data of  ${name} Book</p>
            <p><b>Book Name:</b> ${name}</p>
             `;

            var modallable = document.getElementById('ModalLabel');
            modallable.innerHTML = `
            Do You Want to Delete Book Name: ${name} and it's Records?
            `;

            var modalfooter = document.getElementById('modalfooter');
            modalfooter.innerHTML = `
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button id="deletebtn" type="button" class="btn btn-danger">Delete Pharmacy</button>
             `;

            // Show the modal
            $('#successModal').modal('show');

            var deletebtn = $('#deletebtn');


            if (deletebtn.length) {
                var timeLeft = 5; // Time in seconds
                deletebtn.addClass('disabled'); // Disable the delete button initially

                // Function to update the button text with the countdown timer
                function updateButtonText() {
                    deletebtn.text('Delete (' + timeLeft + 's)');
                }

                // Call the function initially to set the initial button text
                updateButtonText();

                // Set an interval to update the button text every second
                var countdownInterval = setInterval(function() {
                    timeLeft--; // Decrement the time left
                    updateButtonText(); // Update the button text

                    // Check if the countdown has finished
                    if (timeLeft <= 0) {
                        clearInterval(countdownInterval); // Stop the countdown interval
                        deletebtn.removeClass('disabled'); // Re-enable the delete button
                        deletebtn.text('Delete'); // Reset the button text
                    }
                }, 1000); //
            }

            document.getElementById('deletebtn').addEventListener('click', function() {
                window.location.href = `/book/delete/${id}`;
            });
        }
    </script>
@endsection
