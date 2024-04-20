@extends('inc.app')

@section('title')
    Update a Book Record
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
                        <div class="h2 text-center p-3">Update a Book</div>
                    </div>
                    <div class="card-body p-5">
                        <form action="{{ route('book.update', ['id' => $book->id]) }}" method="post" id="bookForm">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form">
                                        <div class="form-group">
                                            <label for="book_name" class="h6">Enter Book Title</label>
                                            <input type="text" value="{{ $book->title }}" name="book_name"
                                                id="book_name" class="form-control" onblur="validateBookData(book_name)"
                                                oninput="validateBookData(book_name)">
                                            <span class="text-danger" id="error_book_name"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form">
                                        <div class="form-group">
                                            <label for="book_name" class="h6">Enter Book Author</label>
                                            <input type="text" value="{{ $book->author }}" name="book_author"
                                                id="book_author" class="form-control" onblur="validateBookData(book_author)"
                                                oninput="validateBookData(book_author)">
                                            <span class="text-danger" id="error_book_author"></span>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form">
                                        <div class="form-group">
                                            <label for="book_name" class="h6">Enter Book Price</label>
                                            <input type="number" min="0" name="book_price" id="book_price"
                                                class="form-control" value="{{ $book->price }}"
                                                onblur="validateBookData(book_price)"
                                                oninput="validateBookData(book_price)">
                                            <span class="text-danger" id="error_book_price"></span>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form">
                                        <div class="form-group">
                                            <label for="book_name" class="h6">Enter Stock Qtty</label>
                                            <input type="number" min="1" name="book_qtt" id="book_qtt"
                                                class="form-control" value="{{ $book->stock }}"
                                                onblur="validateBookData(book_qtt)" oninput="validateBookData(book_qtt)">
                                            <span class="text-danger" id="error_book_qtt"></span>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form">
                                        <div class="form-group">
                                            <label for="book_name" class="h6">Select Categories</label>
                                            <select class="custom-select form-control" name="category_id" id="category_id"
                                                onchange="validateSelect()">
                                                <option value="0" disabled>Select from the list</option>

                                                @foreach ($categories as $cat)
                                                    <option value="{{ $cat->id }}"
                                                        {{ $book['book_category_id'] == $cat->id ? 'selected' : '' }}>
                                                        {{ $cat->name }}</option>
                                                @endforeach

                                            </select>
                                            <span class="text-danger" id="error_category_id"></span>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 d-flex mt-3">
                                    <button class="btn btn-secondary mx-2" onclick="clearForm()"
                                        id="clear">Clear</button>
                                    <button class="btn btn-success mx-2" type="submit" id="addData">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
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



        //selection validation
        function validateSelect() {

            // console.log($('#category_id').val());
            if ($('#category_id').val() === null || $('#category_id').val() === "0") { //check select or njt
                $('#category_id').next('span.text-danger').text("Please select a category");
                return false;
            } else {
                $('#category_id').next('span.text-danger').text(""); // Clear error message if input is not empty
                return true;
            }
        }


        //input validation
        function validateInputs() {
            var validateFeilds = ['#book_name', '#book_author', '#book_price', '#book_qtt'];
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
            $("#book_name, #book_author, #book_price, #book_qtt").val("");
        }


        //handle form sub
        $(document).ready(function() {
            $('#bookForm').on('submit', function(event) {

                event.preventDefault();

                console.log(validateSelect());
                console.log(validateInputs());

                // Perform validation
                if (validateSelect() && validateInputs()) {
                    // If validation complete submit
                    this.submit();
                } else {
                    toastr.warning('Please Fill all required Feilds');
                }
            });


        });
    </script>
@endsection
