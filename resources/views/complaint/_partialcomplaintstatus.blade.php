@section('content1')
    <div class="card-body">
        <h6 class="card-title text-muted"><b>Status : <span style="color: #1e7e34">{{ $complaint->complaintstatus }}</span> </b></h6>
        <hr>
        <div class="row">
            <div class="col"><label>Product Serial Number</label></div>
            <div class="col">: <label class="text-muted">{{ $complaint->productsrno_accountno }}</label></div>
        </div>
        <div class="row">
            <div class="col"><label>Complaint Status</label></div>
            <div class="col">: <label class="text-muted">{{ $complaint->complaintstatus }}</label></div>
        </div>
        <div class="row">
            <div class="col"><label>Complaint Creation Date</label></div>
            <div class="col">: <label class="text-muted">{{ $complaint->complaintdate }}</label></div>
        </div>
        <div class="row">
            <div class="col"><label>Complaint Closed Date</label></div>
            <div class="col">: <label class="text-muted">{{ $complaint->complaintdate }}</label></div>
        </div>
        <div class="row">
            <div class="col"><label>Complaint Carrier</label></div>
            <div class="col">: <label class="text-muted">{{ $complaint->complaintstatus }}</label></div>
        </div>
        <div class="row">
            <div class="col"><label>Ticket Number</label></div>
            <div class="col">: <label class="text-muted">{{ $complaint->ticketno }}</label></div>
        </div>
        <div class="row">
            <div class="col"><label>Name</label></div>
            <div class="col">: <label class="text-muted">{{ $complaint->customername }}</label></div>
        </div>
        <div class="row">
            <div class="col"><label>ASP Name</label></div>
            <div class="col">: <label class="text-muted">{{ $complaint->customername }}</label></div>
        </div>
        <div class="row">
            <div class="col"><label>ASP Contact Number</label></div>
            <div class="col">: <label class="text-muted">{{ $complaint->mobilenumber }}</label></div>
        </div>
    </div>
@endsection
