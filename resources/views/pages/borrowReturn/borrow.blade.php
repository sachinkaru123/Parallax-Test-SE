@extends('inc.app')

@section('title')
    Borrow a Book
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">

            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-2">
                    <div class="card-header">
                        <div class="h2 text-center p-3">Create Borrow Record</div>
                    </div>
                    <div class="card-body p-5">
                        <form action="" method="post" id="bookForm">
                            {{-- {{ route('book.borrow.store') }} --}}
                            @csrf
                            <div class="row m-3">
                                <div class="col-md-6">
                                    <div class="form">
                                        <div class="form-group">
                                            <label for="book_name" class="h6">Enter Book Title</label>
                                            <input type="text" name="book_name" id="book_name" class="form-control"
                                                placeholder="start typing...." onblur="validateBookData(book_name)"
                                                oninput="validateBookData(book_name)">
                                            <span class="text-danger" id="error_book_name"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form">
                                        <div class="form-group">
                                            <label for="book_name" class="h6">Select Member</label>
                                            <select class="custom-select form-control" name="member" id="member">
                                                <option value="0" selected disabled>Select from the list</option>
                                                @foreach ($members as $member)
                                                    <option value="{{ $member->id }}">{{ $member->name }}</option>
                                                @endforeach

                                            </select>
                                            <span class="text-danger" id="error_member"></span>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="row m-3">
                                <div class="col-md-6" id="bookInfo">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="h4">Book Info</div>
                                        </div>
                                        <div class="card-body">
                                            <table>
                                                <tr>
                                                    <td><label class="w-100 font-w-100">Title:</label></td>
                                                    <td> <span id="book_title_name">Not set yet.</span></td>

                                                </tr>
                                                <tr>
                                                    <td class="mx-1"><label class="w-100">Author:</label></td>
                                                    <td><span id="book_auth_name">Not set yet.</span></td>
                                                </tr>
                                                <tr>
                                                    <td><label class="w-100">Price:</label></td>
                                                    <td>Rs<span id="book_price"></span></td>
                                                </tr>

                                                <tr>
                                                    <td><label class="w-100">Category:</label></td>
                                                    <td><span id="book_cate"></span></td>
                                                </tr>

                                                <tr>
                                                    <td><label class="me-1">Avaliable Stock:</label></td>
                                                    <td><span id="book_stock"></span></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="row">
                                <div class="col-md-6 d-flex mt-3">
                                    <button class="btn btn-secondary mx-2" onclick="clearForm()" id="clear"
                                        type="button">Clear</button>
                                    <button class="btn btn-primary mx-2" type="button" id="addData">Add Book To
                                        List</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mt-3">
            <div class="col-md-8">
                <table class="table table-sm" id="bookTable">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Book Name</th>
                            <th scope="col">Book price</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="btn btn-success" id="addRecordbtn">Add Records</div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var book_id, book_name, book_price, book_count, book_author, book_cate;
        var bookList = [];

        $(function() {

            $('#bookInfo').addClass('d-none');


            $("#book_name").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('search.books') }}",
                        data: {
                            term: request.term
                        },
                        dataType: "json",
                        success: function(data) {
                            response(data);
                            console.log(data);
                        }
                    });
                },
                minLength: 2,
                select: function(event, ui) {

                    console.log(ui.item['author']);
                    $('#bookInfo').removeClass('d-none');


                    book_id = ui.item.id;
                    book_name = ui.item.value;
                    book_price = ui.item.price;
                    book_count = ui.item.stock;
                    book_author = ui.item.author;
                    book_cate = ui.item.category_name;

                    $("#book_name").val(book_name);
                    // $("#book_name").text(ui.title);
                    // $("#book_author").text(ui.item['author']);
                    // $("#book_category").text(ui.item.category_name);
                    // $("#book_stock").text(ui.item.stock);
                    // $("#book_price").text(ui.item.price);

                    viewData()


                    return false;
                }
            });

        });

        function viewData() {
            $("#book_title_name").text(book_name);
            $("#book_cate").text(book_cate);
            $("#book_auth_name").text(book_author);
            $("#book_price").text(book_price);
            $(`#book_stock`).text(book_count);

            // book_auth_name
        }

        function AddToList() {
            if (book_count <= 0) {
                toastr.warning('Selected Book is  out of stock!');
            } else {
                bookList.push({
                    "book_name": book_name,
                    "book_id": book_id,
                    "book_price": book_price,
                    "book_cate": book_cate
                });
            }
            buildTable()
        }

        function buildTable() {
            $('#bookTable tbody').empty(); // Clear existing rows except the header
            bookList.forEach((element, index) => {
                var newRow = $('<tr>').append(
                    $('<td>').text(element.book_id),
                    $('<td>').text(element.book_name),
                    $('<td>').text(element.book_price),
                    $('<td>').append($('<button>').addClass('btn btn-danger').text(
                            'X')
                        .on(
                            'click',
                            function() {
                                bookList.splice(index,
                                    1); // Remove the item from the list
                                buildTable(); // Rebuild the table
                            }))
                );
                $('#bookTable tbody').append(newRow);
                // clearMedInputs()
            });
        }

        $("#addRecordbtn").on("click", function() {
            $('#bookInfo').addClass('d-none');
            $("#book_name").val("");

            if (bookList.length == 0) {
                toastr.warning('No Book Records');

            } else {

                let memberId = $('#member').val()


                if (validateSelect()) {
                    //    console.log(bookList);

                    $.ajax({
                        url: "{{ route('add.borowal.record') }}",
                        data: {
                            bookList: bookList,
                            memberId: memberId
                        },
                        dataType: "json",
                        success: function(response) {
                            toastr.success('Record Insert Succesfull');

                        },
                        error: function(error) {
                            toastr.error('An error occurred while inserting the record: ');
                        }
                    });
                }
            }

        });
    </script>


    <script>
        //validate function
        function validateBookData(element) {

            var input = $(element).val();
            if (input === "") {
                //access next span 
                $(element).next('span.text-danger').text("Please fill this feild");
                return false;
            } else {
                $(element).next('span.text-danger').text(""); // Clear error message if input is not empty
                return true;
            }

        }

        //when click data
        $("#addData").on("click", function() {
            $('#bookInfo').addClass('d-none');

            if (validateInputs()) {
                AddToList()
                $("#book_name").val("");
            }
        });




        //selection validation
        function validateSelect() {

            // console.log($('#category_id').val());
            if ($('#member').val() === null || $('#member').val() === "0") { //check select or njt
                $('#member').next('span.text-danger').text("Please select a member");
                return false;
            } else {
                $('#member').next('span.text-danger').text(""); // Clear error message if input is not empty
                return true;
            }
        }


        //input validation
        function validateInputs() {
            var validateFeilds = ['#book_name'];
            var status = true;
            validateFeilds.forEach(element => {
                validateBookData(element);

                if (!validateBookData(element)) {
                    status = false;
                }
            });
            return status;
        }


        function clearForm() {
            $("#book_name").val("");
            $("#member").val('0');
        }
    </script>
@endsection
