@extends('theme.layout.master')

@push('css')
    <style>
        .custom_pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin-top: 30px;
            padding: 20px 0;
        }

        .custom_pagination a,
        .custom_pagination span {
            display: inline-block;
            padding: 8px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-decoration: none;
            color: #333;
            transition: all 0.3s ease;
        }

        .custom_pagination a:hover {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }

        .custom_pagination .active {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }

        .custom_pagination .disabled {
            opacity: 0.5;
            cursor: not-allowed;
            pointer-events: none;
        }

        .pagination_info {
            text-align: center;
            margin-top: 15px;
            color: #666;
            font-size: 14px;
        }
    </style>
@endpush
@section('navbar-title')
    <h2 class="navbar_PageTitle">Notification</h2>
@endsection
@section('content')
    <section class="notification_sec">
        <div class="container-fluid custom_container">
            <div class="row">
                <div class="col-md-12">
                    <div class="shadow_box_wrapper notification_wrapper">
                        {{-- <button type="button" class="btn btn_blue">Mark all as Read <i class="fa-solid fa-check"></i></button> --}}
                        <ul>
                            @forelse ($notificationsss as $notification)
                                <li>
                                    <div class="notification_user_details">
                                        <div class="img_name_user">
                                            <div class="status_time_img">
                                                <img
                                                    src="{{ asset('website') }}/{{ $notification->user->profile->pic ?? 'users/no_avatar.jpg' }}">
                                            </div>
                                            <div class="user_profile">
                                                <h3>{{ $notification->title }}</h3>
                                                <h4>{{ $notification->message }}</h4>
                                            </div>
                                        </div>
                                        <p><i class="fa-solid fa-circle"></i>
                                            {{ $notification->created_at->diffForHumans() }}</p>
                                    </div>
                                </li>
                            @empty
                                <li>
                                    <div class="notification_user_details">
                                        <p class="text-center">No notifications found.</p>
                                    </div>
                                </li>
                            @endforelse
                        </ul>

                        {{-- Custom Pagination --}}
                        @if ($notificationsss->hasPages())
                            <div class="custom_pagination">
                                {{-- Previous Button --}}
                                @if ($notificationsss->onFirstPage())
                                    <span class="disabled">« Previous</span>
                                @else
                                    <a href="{{ $notificationsss->previousPageUrl() }}">« Previous</a>
                                @endif

                                {{-- Page Numbers (Smart Pagination - Show only 5 pages at a time) --}}
                                @php
                                    $currentPage = $notificationsss->currentPage();
                                    $lastPage = $notificationsss->lastPage();
                                    $startPage = max(1, $currentPage - 2);
                                    $endPage = min($lastPage, $currentPage + 2);

                                    // Adjust if we're near the beginning or end
                                    if ($currentPage <= 3) {
                                        $endPage = min(5, $lastPage);
                                    }
                                    if ($currentPage > $lastPage - 3) {
                                        $startPage = max(1, $lastPage - 4);
                                    }
                                @endphp

                                {{-- First Page --}}
                                @if ($startPage > 1)
                                    <a href="{{ $notificationsss->url(1) }}">1</a>
                                    @if ($startPage > 2)
                                        <span class="disabled">...</span>
                                    @endif
                                @endif

                                {{-- Page Range --}}
                                @for ($page = $startPage; $page <= $endPage; $page++)
                                    @if ($page == $currentPage)
                                        <span class="active">{{ $page }}</span>
                                    @else
                                        <a href="{{ $notificationsss->url($page) }}">{{ $page }}</a>
                                    @endif
                                @endfor

                                {{-- Last Page --}}
                                @if ($endPage < $lastPage)
                                    @if ($endPage < $lastPage - 1)
                                        <span class="disabled">...</span>
                                    @endif
                                    <a href="{{ $notificationsss->url($lastPage) }}">{{ $lastPage }}</a>
                                @endif

                                {{-- Next Button --}}
                                @if ($notificationsss->hasMorePages())
                                    <a href="{{ $notificationsss->nextPageUrl() }}">Next »</a>
                                @else
                                    <span class="disabled">Next »</span>
                                @endif
                            </div>

                            {{-- Pagination Info --}}
                            <div class="pagination_info">
                                Showing {{ $notificationsss->firstItem() }} to {{ $notificationsss->lastItem() }} of
                                {{ $notificationsss->total() }} notifications
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('js')
@endpush
