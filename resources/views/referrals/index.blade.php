@extends('layouts.app')

@section('css')
<link href="{{ asset('css/custom.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"><h1>Referrals</h1></div>

                <div class="panel-body">
                    <div>@include('partials.createReferralButton')</div>
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    <table class="table" id="referral-table">
                        <thead>
                            <th>Country</th>
                            <th>Reference No</th>
                            <th>Organisation</th>
                            <th>Province</th>
                            <th>District</th>
                            <th>City</th>
                            <th>Street Address</th>
                            <th>Gps Location</th>
                            <th>Facility Name</th>
                            <th>Facility Type</th>
                            <th>Provider Name</th>
                            <th>Position</th>
                            <th>Phone</th>
                            <th>eMail</th>
                            <th>Website</th>
                            <th>Pills Available</th>
                            <th>Code To Use</th>
                            <th>Type of Service</th>
                            <th>Note</th>
                            <th>Womens Evaluation</th>
                            <th>Action</th>
                        </thead>
                        @foreach($referrals as $referral)
                        <tr>
                            <td>{{ $referral->country }} </td>
                            <td>{{ $referral->reference_no }} </td>
                            <td>{{ $referral->organisation }} </td>
                            <td>{{ $referral->province }} </td>
                            <td>{{ $referral->district }} </td>
                            <td>{{ $referral->city }} </td>
                            <td>{{ $referral->street_address }} </td>
                            <td>{{ $referral->gps_location }} </td>
                            <td>{{ $referral->facility_name }} </td>
                            <td>{{ $referral->facility_type }} </td>
                            <td>{{ $referral->provider_name }} </td>
                            <td>{{ $referral->position }} </td>
                            <td>{{ $referral->phone }} </td>
                            <td>{{ $referral->email }} </td>
                            <td>{{ $referral->website }} </td>
                            <td>{{ $referral->pills_available }} </td>
                            <td>{{ $referral->code_to_use }} </td>
                            <td>{{ $referral->type_of_service }} </td>
                            <td>{{ $referral->note }} </td>
                            <td>{{ $referral->womens_evaluation }} </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                      Action
                                    </button>
                                    <div class="dropdown-menu">
                                        <ul>
                                            <li>
                                                <a class="dropdown-item" href="{{url('comments/create/'.$referral->id)}}">Add Comment</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{url('comments/referral/'.$referral->id)}}">View Comments</a>
                                            </li>
                                        </ul>
                                    </div>
                                  </div>
                            </td>
                        </tr>
                        @endforeach
                        <tfoot>
                            <tr>
                                <th>Country</th>
                                <th>Reference No</th>
                                <th>Organisation</th>
                                <th>Province</th>
                                <th>District</th>
                                <th>City</th>
                                <th>Street Address</th>
                                <th>Gps Location</th>
                                <th>Facility Name</th>
                                <th>Facility Type</th>
                                <th>Provider Name</th>
                                <th>Position</th>
                                <th>Phone</th>
                                <th>eMail</th>
                                <th>Website</th>
                                <th>Pills Available</th>
                                <th>Code To Use</th>
                                <th>Type of Service</th>
                                <th>Note</th>
                                <th>Womens Evaluation</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                {{-- <div class="panel-footer">
                    {{ $referrals->links() }}
                </div> --}}

            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script type="text/javascript">
let table = new DataTable('#referral-table', {
    scrollX: true,
    initComplete: function () {
        this.api()
            .columns()
            .every(function () {
                let column = this;
                let title = column.footer().textContent;
 
                // Create input element
                let input = document.createElement('input');
                input.placeholder = title;
                column.footer().replaceChildren(input);
 
                // Event listener for user input
                input.addEventListener('keyup', () => {
                    if (column.search() !== this.value) {
                        column.search(input.value).draw();
                    }
                });
            });
    }

});
</script>
@endsection