@extends('layouts.admin')

@section('content')
<div class="order-tracking-container" style="max-width:800px; margin:50px auto; font-family:Arial, sans-serif;">
    <h2 style="text-align:center; margin-bottom:30px;">Order Tracking</h2>

    <ul class="order-steps" style="list-style:none; display:flex; justify-content:space-between; padding:0; position:relative;">
        <!-- Line connecting steps -->
        <div style="position:absolute; top:15px; left:0; width:100%; height:4px; background:#ddd; z-index:0;"></div>

        <li style="position:relative; z-index:1; text-align:center; flex:1;">
            <div style="width:30px; height:30px; margin:0 auto; border-radius:50%; background:#4CAF50; color:white; display:flex; align-items:center; justify-content:center;">1</div>
            <p style="margin-top:10px;">Ordered</p>
        </li>
        <li style="position:relative; z-index:1; text-align:center; flex:1;">
            <div style="width:30px; height:30px; margin:0 auto; border-radius:50%; background:#4CAF50; color:white; display:flex; align-items:center; justify-content:center;">2</div>
            <p style="margin-top:10px;">Processed</p>
        </li>
        <li style="position:relative; z-index:1; text-align:center; flex:1;">
            <div style="width:30px; height:30px; margin:0 auto; border-radius:50%; background:#bbb; color:white; display:flex; align-items:center; justify-content:center;">3</div>
            <p style="margin-top:10px;">Shipped</p>
        </li>
        <li style="position:relative; z-index:1; text-align:center; flex:1;">
            <div style="width:30px; height:30px; margin:0 auto; border-radius:50%; background:#bbb; color:white; display:flex; align-items:center; justify-content:center;">4</div>
            <p style="margin-top:10px;">Delivered</p>
        </li>
    </ul>
</div>
@endsection
