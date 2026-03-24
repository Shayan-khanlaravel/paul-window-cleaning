@extends('theme.layout.master')

@push('css')

@endpush
@section('navbar-title')
    <div class="custom_justify_between create_clients_navbar">
        <a href="{{url('clients')}}" class="back_btn_navbar">
            <i class="fa-solid fa-chevron-left"></i>
        </a>
        <h2 class="navbar_PageTitle">Schedule</h2>
    </div>
@endsection
@section('content')
    @if(auth()->user()->hasRole('admin'))
        <section class="create_clients_sec">
            <div class="container-fluid custom_container">
                <div class="row card_alignment">
                    <div class="col-md-12">
                        <div class="shadow_box_wrapper">
                            <div class="custom_details_wrapper">
                                <div class="client_info">
                                    <div class="row custom_row">
                                        <div class="col-md-12">
                                            <div class="custom_justify_between">
                                                <h2>{{$client->user->name??''}}</h2>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="txt_field_wrapper">
                                                <label>Email :</label>
                                                <span>{{$client->user->email??''}}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="txt_field_wrapper">
                                                <label>Phone :</label>
                                                {{--                                                <span>+ {{$client->user->profile->phone??''}}</span>--}}
                                                <span>{{ substr_replace(substr_replace($client->user->profile->phone??'', '-', 3, 0), '-', 7, 0) }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="txt_field_wrapper">
                                                <label>Date Created :</label>
                                                <span><td>{{ $client->user->created_at ? $client->user->created_at->format('d-m-Y') : '' }}</td></span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="txt_field">
                                                <h4>Job Description :</h4>
                                                <span>{{$client->description??''}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-12">
                        <div class="create_clients_wrapper shadow_box_wrapper">
                            <form method="post" action="{{ route('client_schedule_save', ['id' => $client->id]) }}" class="form-horizontal" id="clientValidate" enctype="multipart/form-data">
                                @csrf
                                <div class="row create_client_cus_row">
                                    <div class="col-md-12">
                                        @if (empty($client->start_date) || empty($client->end_date))
                                            <div class="no_schedule">
                                                <h4>There’s no schedule available right now.</h4>
                                            </div>
                                        @else
                                            @foreach ($months as $monthIndex => $month)
                                                <div class="monthly_schedule_box">
                                                    <div class="monthly_schedule">
                                                        <h4>{{ $month['month'] }} {{ $month['year'] }}</h4>
                                                    </div>
                                                    <div class="custom_checkbox_wrapper assign_week">
                                                        @foreach ($month['weeks'] as $weekIndex => $week)
                                                            @php
                                                                $isChecked = false;
                                                                if (!empty($client->clientSchedule)) {
                                                                    foreach ($client->clientSchedule as $schedule) {
                                                                        if ($schedule->start_date === $week['start_date'] && $schedule->end_date === $week['end_date']) {
                                                                            $isChecked = true;
                                                                            break;
                                                                        }
                                                                    }
                                                                }
                                                            @endphp
                                                            <div class="custom_radio">
                                                                <input class="form-check-input" value="{{ $week['start_date'] }}" type="checkbox" data-id="{{ $monthIndex }}_{{ $weekIndex }}" data-end="{{ $week['end_date'] }}" id="week_{{ $monthIndex }}_{{ $weekIndex }}"
                                                                       @if($isChecked) checked @endif>
                                                                <label class="form-check-label" for="week_{{ $monthIndex }}_{{ $weekIndex }}">
                                                                    Week {{ $weekIndex + 1 }} ({{ $week['start_date'] }} to {{ $week['end_date'] }})
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <div class="add_frequency_week_note"></div>
                                                </div>
                                            @endforeach

                                            <div class="col-md-12">
                                                <div class="custom_justify_between">
                                                    <button type="button" class="btn_global btn_grey">Cancel<i class="fa-solid fa-close"></i></button>
                                                    <button type="submit" class="btn_global btn_blue submitButton">Update<i class="fa-solid fa-plus"></i></button>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    @elseif(auth()->user()->hasRole('staff'))
        <section class="create_clients_sec">
            <div class="container-fluid custom_container">
                <div class="row card_alignment">
                    <div class="col-md-12">
                        <div class="shadow_box_wrapper">
                            <div class="custom_details_wrapper">
                                <div class="client_info">
                                    <div class="row custom_row">
                                        <div class="col-md-12">
                                            <div class="custom_justify_between">
                                                <h2>{{$client->user->name??''}}</h2>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="txt_field_wrapper">
                                                <label>Email :</label>
                                                <span>{{$client->user->email??''}}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="txt_field_wrapper">
                                                <label>Phone :</label>
                                                <span>+ {{$client->user->phone??''}}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="txt_field_wrapper">
                                                <label>Date Created :</label>
                                                <span><td>{{ $client->user->created_at ? $client->user->created_at->format('d-m-Y') : '' }}</td></span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="txt_field">
                                                <h4>Job Description :</h4>
                                                <span>{{$client->description??''}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-12">
                        <div class="create_clients_wrapper shadow_box_wrapper">
                            <form method="post" action="{{ route('client_schedule_save', ['id' => $client->id]) }}" class="form-horizontal" id="clientValidate" enctype="multipart/form-data">
                                @csrf
                                <div class="row create_client_cus_row">
                                    <div class="col-md-12">
                                        @if (empty($client->start_date) || empty($client->end_date))
                                            <div class="no_schedule">
                                                <h4>There’s no schedule available right now.</h4>
                                            </div>
                                        @else
                                            @foreach ($months as $monthIndex => $month)
                                                <div class="monthly_schedule_box">
                                                    <div class="monthly_schedule">
                                                        <h4>{{ $month['month'] }} {{ $month['year'] }}</h4>
                                                    </div>
                                                    <div class="custom_checkbox_wrapper assign_week">
                                                        @foreach ($month['weeks'] as $weekIndex => $week)
                                                            @php
                                                                $isChecked = false;
                                                                if (!empty($client->clientSchedule)) {
                                                                    foreach ($client->clientSchedule as $schedule) {
                                                                        if ($schedule->start_date === $week['start_date'] && $schedule->end_date === $week['end_date']) {
                                                                            $isChecked = true;
                                                                            break;
                                                                        }
                                                                    }
                                                                }
                                                            @endphp
                                                            <div class="custom_radio">
                                                                <input class="form-check-input" value="{{ $week['start_date'] }}" type="checkbox" data-id="{{ $monthIndex }}_{{ $weekIndex }}" data-end="{{ $week['end_date'] }}" id="week_{{ $monthIndex }}_{{ $weekIndex }}"
                                                                       @if($isChecked) checked @endif>
                                                                <label class="form-check-label" for="week_{{ $monthIndex }}_{{ $weekIndex }}">
                                                                    Week {{ $weekIndex + 1 }} ({{ $week['start_date'] }} to {{ $week['end_date'] }})
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <div class="add_frequency_week_note"></div>
                                                </div>
                                            @endforeach

                                            <div class="col-md-12">
                                                <div class="custom_justify_between">
                                                    <button type="button" class="btn_global btn_grey">Cancel<i class="fa-solid fa-close"></i></button>
                                                    <button type="submit" class="btn_global btn_blue submitButton">Update<i class="fa-solid fa-plus"></i></button>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    @endif

@endsection
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script>
        let clientScheduleData = @json($client->clientSchedule);
    </script>

    <script>
        $(document).ready(function () {
            function appendFieldsForCheckedCheckbox(checkbox) {
                var This = $(checkbox);
                var id = This.data("id");
                var weekLabel = This.next("label").text();
                var monthName = This.closest(".monthly_schedule_box").find(".monthly_schedule h4").text().split(" ")[0];
                var startDate = This.val();
                var endDate = This.data("end");

                var scheduleData = clientScheduleData.find(schedule =>
                    schedule.start_date === startDate && schedule.end_date === endDate
                );

                var paymentType = scheduleData ? scheduleData.payment_type : 'cash';
                var note = scheduleData ? scheduleData.note : '';

                This.closest(".monthly_schedule_box").find('.add_frequency_week_note').append(`
        <div class="custom_cost_content" id="week_note_${id}">
            <h4>Details for ${weekLabel}</h4>
            <div class="row">
                <div class="col-md-6">
                    <div class="appended_radio">
                        <h4>Payment Type:</h4>
                        <div class="radio_btn_wrapper">
                            <label>
                                <input type="radio" name="month[${monthName}][week${id.split('_')[1]}][payment_type]" value="cash" ${paymentType === 'cash' ? 'checked' : ''}> Cash
                            </label>
                            <label>
                                <input type="radio" name="month[${monthName}][week${id.split('_')[1]}][payment_type]" value="invoice" ${paymentType === 'invoice' ? 'checked' : ''}> Invoice
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="custom_week_notes">
                        <div class="txt_field">
                            <label>Note:</label>
                            <textarea name="month[${monthName}][week${id.split('_')[1]}][note]" placeholder="Notes For Week" class="form-control" rows="5">${note}</textarea>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="month[${monthName}][week${id.split('_')[1]}][start_date]" value="${startDate}">
                <input type="hidden" name="month[${monthName}][week${id.split('_')[1]}][end_date]" value="${endDate}">
                <div class="col-md-12">
                    <h4>Price List</h4>
                    <div class="price_list_wrapper appended_price_list">
                        ${generatePriceList(id, monthName, scheduleData)}
                    </div>
                </div>
            </div>
        </div>
    `);
            }

            function generatePriceList(id, monthName, scheduleData) {
                let prices = @json($client->clientPrice);
                let schedulePrices = scheduleData && scheduleData.client_schedule_price ? scheduleData.client_schedule_price : [];
                let priceHtml = "";

                prices.forEach(price => {
                    let isChecked = schedulePrices.some(schedule => schedule.price_id == price.id);

                    priceHtml += `
            <div class="price_list">
                <div class="table_checkbox">
                    <input class="form-check-input" type="checkbox" value="${price.id}" name="month[${monthName}][week${id.split('_')[1]}][prices][]" data-name="${price.name}" data-value="${price.value}" ${isChecked ? 'checked' : ''}>
                </div>
                <label>${price.name ?? ''}</label>
                <span>$${price.value ?? ''}</span>
            </div>
        `;
                });

                return priceHtml;
            }

            $(".assign_week input[type='checkbox']:checked").each(function () {
                appendFieldsForCheckedCheckbox(this);
            });

            $(document).on("change", ".assign_week input[type='checkbox']", function () {
                var This = $(this);
                if (This.is(":checked")) {
                    appendFieldsForCheckedCheckbox(This);
                } else {
                    var id = This.data("id");
                    $("#week_note_" + id).remove();
                }
            });

            $(".submitButton").on("click", function (e) {
                e.preventDefault();
                let isValid = true;
                let errorMessage = "";
                let firstInvalidElement = null;

                if ($(".assign_week input[type='checkbox']:checked").length === 0) {
                    isValid = false;
                    errorMessage = "Please select at least one week.";
                    firstInvalidElement = $(".assign_week input[type='checkbox']").first();
                }

                $(".custom_cost_content").each(function () {
                    if ($(this).find("textarea").val().trim() === "") {
                        isValid = false;
                        errorMessage = "Please fill out the note for selected weeks.";
                        firstInvalidElement = firstInvalidElement || $(this).find("textarea");
                    }

                    if ($(this).find(".price_list_wrapper input[type='checkbox']:checked").length === 0) {
                        isValid = false;
                        errorMessage = "Please Check at least one selected week's price list.";
                        firstInvalidElement = firstInvalidElement || $(this).find(".price_list_wrapper input[type='checkbox']").first();
                    }
                });

                if (!isValid) {
                    Swal.fire({
                        icon: "warning",
                        title: "Warning",
                        text: errorMessage,
                    }).then(() => {
                        if (firstInvalidElement) {
                            $('html, body').animate({
                                scrollTop: firstInvalidElement.offset().top - 100
                            }, 500);
                            firstInvalidElement.focus();
                        }
                    });
                } else {
                    $("#clientValidate").submit();
                }
            });
        });
    </script>

@endpush
