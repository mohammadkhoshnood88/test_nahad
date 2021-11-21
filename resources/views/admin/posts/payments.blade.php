@extends('layouts.admin')

@section('content')
    <div class="page-loader">
        <div class="page-loader__spinner">
            <svg viewbox="25 25 50 50">
                <circle cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle>
            </svg>
        </div>
    </div>

    <section class="content">
         <div class="content__inner">
             <header class="content__title">
                 <h1 class="text-right">تراکنش های 18 چرخ </h1>
             </header>

             <div class="card">
                 <div class="card-body">
                     <h4 class="card-title text-right">تراکنش های اخیر </h4>
                     <div class="table-responsive data-table text-center dir_rtl">
                         <table id="data-table" class="table table-hover table-dark table-bordered">
                             <thead class="thead-dark">
                             <tr>
                                 <th># </th>
                                 <th>عنوان آگهی </th>
                                 <th>شماره موبایل </th>
                                 <th>شناسه پرداخت </th>
                                 <th>مبلغ </th>
                                 <th>نوع سفارش </th>
                                 <th>تاریخ پرداخت</th>
                                 <th>تاریخ ثبت</th>
                                 <th>وضعیت </th>
                             </tr>
                             </thead>
                             <tbody>
                                 @foreach($payments as $payment)
                                    @foreach($payment as $p)
                             <tr>
                                 <td>{{$loop->index + 1}}</td>
                                 <td>
                                 {{Str::words($p[0]->post->subject, $words = 3, $end = '...')}}
                                 </td>
                                 
                                 <td>{{$p[0]->post->phone_number}}</td>

                                 <td>
                                     {{ $p[0]->invoice() == null ? "-" : ($p[0]->invoice()->transaction_number == 0 ? "-" : $p[0]->invoice()->transaction_number) }}
                                 </td>                                 
                                 
                                 <td>{{$p[0]->invoice() != null ? $p[0]->invoice()->amount : '-' }}</td>
                                 

                                <td>
                                     @foreach($p as $option)
                                     <span class="badge badge-secondary">{{option_name($option->option_name)}}</span>
                                     @endforeach
                                </td>
                                <td>
                                    {{$p[0]->invoice() != null ? \Morilog\Jalali\Jalalian::forge($p[0]->invoice()->created_at)->format('H:i - Y/m/d') : "-"}}
                                </td>
                                
                                <td>
                                    {{\Morilog\Jalali\Jalalian::forge($p[0]->created_at)->format('Y/m/d')}}
                                </td>
                                
                                 <td>
                                     @if($p[0]->invoice() != null)
                                        @if($p[0]->invoice()->transaction_number)
                                    <p style=" color: springgreen">
                                        <i style="font-size: 1.5rem; margin-right: 5px" class="zwicon-checkmark-circle "></i>
                                        پرداخت موفق
                                    </p>
                                        @else
                                    <p style=" color: red">
                                        <i style="font-size: 1.5rem; margin-right: 5px" class="zwicon-close-circle "></i>
                                        پرداخت ناموفق
                                    </p>
                                        @endif
                                    @else
                                    <p style=" color: orange">
                                        <i style="font-size: 1.5rem; margin-right: 5px" class="zwicon-clock "></i>
                                        عدم پرداخت
                                    </p>
                                    @endif
                                 </td>
                             </tr>
                                @endforeach
                             @endforeach

                             </tbody>
                         </table>
                     </div>
                 </div>
             </div>
         </div>
     </section>
@endsection

@section('scripts')
    
@endsection