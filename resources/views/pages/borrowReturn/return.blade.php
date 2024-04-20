@extends('inc.app')

@section('title')
    Return a Book
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">

            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mt-2">
                    <div class="card-header">
                        <div class="h2 text-center p-3">Mark Return Record</div>
                    </div>
                    <div class="card-body p-5">
                        <div class="row justify-content-center mt-3">
                            <div class="col-md-8">
                                <table class="table table-sm" id="bookTable">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Book Name</th>
                                            <th scope="col">Book price</th>
                                            <th scope="col">Member name</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($borrows as $item)
                                            <tr>
                                                <td>{{ $item->id }}</td>
                                                <td>{{ $item->book->title }}</td>
                                                <td>{{ $item->book->price }}</td>
                                                <td>{{ $item->member->name }}</td>
                                                <td>
                                                    @if ($item->status == 'Pending')
                                                        <div class="btn btn-primary" id="markRecived" data-bs-toggle="modal"
                                                            data-bs-target="#bookRecivedModal"
                                                            onclick="modalDataCreate({{ $item->id }},'{{ $item->book->title }}','{{ $item->member->name }}')">
                                                            Mark as Received</div>
                                                    @else
                                                        <div class="btn btn-secondary disabled">Received</div>
                                                    @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="bookRecivedModal" tabindex="-1" aria-labelledby="bookRecivedModalLable"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="bookRecivedModalLable"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="confirm">Confirm</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="row ">
            <div class="col-md-12 d-flex align-items-center justify-content-center">
                {{ $borrows->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var rec_id;



        function modalDataCreate(id, title, memberName) {
            rec_id = id;
            $("#bookRecivedModalLable").html("Confirm Recived Book : " + title);
            $("#modal-body").html("Please Confirm Recived Book : " + title + ",<br> by : " + memberName);

        }

        $('#confirm').on('click', function() {
            $.ajax({
                url: "{{ route('return.confirm') }}",
                data: {
                    rec_id: rec_id,
                },
                dataType: "json",
                success: function(response) {
                    toastr.success('Record update Succesfull');
                    setInterval(() => {
                        location.reload();

                    }, 1000);

                },
                error: function(error) {
                    toastr.error('An error occurred while inserting the record: ');
                }
            });
        });
    </script>
@endsection
