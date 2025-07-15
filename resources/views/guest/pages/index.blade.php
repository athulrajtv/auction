@extends('guest.layouts.master')
@section('body')

<section class="product-tab-section">
    <div class="cat-tab">
        <div class="container">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                @foreach($data as $index => $category)
                <li class="nav-item" role="presentation">
                    <button class="nav-link category-tab {{ $index === 0 ? 'active' : '' }}"
                        id="tab-{{ $category->id }}-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#tab-{{ $category->id }}"
                        type="button"
                        role="tab"
                        aria-controls="tab-{{ $category->id }}"
                        aria-selected="{{ $index === 0 ? 'true' : 'false' }}">
                        {{ $category->category }}
                    </button>
                </li>
                @endforeach
            </ul>

        </div>
    </div>

    <div class="tab-content" id="myTabContent">
        @foreach($data as $index => $category)
        <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" id="tab-{{ $category->id }}" role="tabpanel" aria-labelledby="tab-{{ $category->id }}-tab">
            <div class="tc">
                <div class="section-title text-center mb-15 animated fadeInUp">
                    <h2>{{ $category->category }} Live Auctions</h2>
                    <div class="int-divider"></div>
                </div>

                @php
                $products = $item->where('category_id', $category->id);
                @endphp

                <div class="row ">
                    @forelse ($products as $product)
                    <div class="col-xl-3 col-lg-2 col-md-4 col-12">
                        <div class="p-box">
                            <h2>{{ $product->product_name }}</h2>
                            <div class="mrp">MRP : ₹{{ number_format($product->price, 2) }}</div>
                            <img src="/uploads/{{ $product->image }}" class="img-fluid" alt="">
                            <div class="price-times">
                                <div class="auction-id">Auction ID. {{ $product->id }}</div>
                                <div class="bids">3 × ★</div>
                            </div>
                            <div class="price-time">
                                <div class="price" id="price-{{ $product->id }}">
                                    ₹ {{ number_format($product->current_price, 2) }}
                                </div>
                                <div class="time">
                                    @php
                                    $endTime = \Carbon\Carbon::parse($product->start_time)->addSeconds($product->duration_seconds);
                                    @endphp

                                    <strong class="countdown" data-id="{{ $product->id }}" data-endtime="{{ $endTime->toIso8601String() }}">
                                        00:00:00
                                    </strong><br>
                                    <span class="user" id="user-{{ $product->id }}">
                                        {{ $product->last_bid_user ?? '-' }}
                                    </span>
                                </div>
                            </div>
                            <div class="actions">
                                <button class="btn btn-cart"><i class="fa fa-shopping-cart"></i></button>
                                <button class="btn btn-cart">A</button>
                                <button class="btn btn-bid bid-btn" data-id="{{ $product->id }}" data-username="{{ auth()->user()->name }}">BID NOW</button>
                            </div>
                        </div>
                    </div>
                    @empty
                    <p>No products found in this category.</p>
                    @endforelse
                </div>

            </div>
        </div>
        @endforeach
    </div>

</section>

<section class="video-section">
    <div class="container text-center">
        <div class="section-title animated fadeInUp">
            <h2>How It Works</h2>
            <div class="int-divider"></div>
        </div>

        <div class="video-wrapper">
            <iframe
                src="https://www.youtube.com/embed/dQw4w9WgXcQ"
                title="How It Works"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen>
            </iframe>
        </div>
    </div>
</section>




<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script>
    Pusher.logToConsole = true;

    var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
        cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
        forceTLS: true
    });

    var channel = pusher.subscribe('auction-channel');
    channel.bind('bid-placed', function(data) {
        console.log('Received bid:', data);

        const priceEl = document.getElementById('price-' + data.productId);
        if (priceEl) {
            priceEl.textContent = '₹ ' + Number(data.newPrice).toFixed(2);
        }

        const userEl = document.getElementById('user-' + data.productId);
        if (userEl) {
            userEl.textContent = data.username;
        }
    });

    document.querySelectorAll('.bid-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const productId = this.dataset.id;
            const username = this.dataset.username;

            fetch(`/bid/${productId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    username: username
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Bid placed successfully:', data);
                // Do NOT manually update the DOM here
                // Let Pusher handle real-time update!
            });
        });
    });
</script>



<script>
    function startCountdown(endTime, productId) {
        const timerEl = document.querySelector(`.countdown[data-id="${productId}"]`);
        if (!timerEl) return;

        if (timerEl._interval) clearInterval(timerEl._interval);

        function updateTimer() {
            const now = new Date();
            const distance = new Date(endTime) - now;

            if (distance <= 0) {
                timerEl.textContent = 'Auction Completed';
                timerEl.classList.add('auction-completed');
                clearInterval(timerEl._interval);
                return;
            }

            const hours = String(Math.floor((distance / (1000 * 60 * 60)) % 24)).padStart(2, '0');
            const minutes = String(Math.floor((distance / (1000 * 60)) % 60)).padStart(2, '0');
            const seconds = String(Math.floor((distance / 1000) % 60)).padStart(2, '0');

            timerEl.textContent = `${hours}:${minutes}:${seconds}`;
        }

        updateTimer();
        timerEl._interval = setInterval(updateTimer, 1000);
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.countdown').forEach(el => {
            const productId = el.dataset.id;
            const endTime = el.dataset.endtime;
            startCountdown(endTime, productId);
        });
    });
</script>



@endsection