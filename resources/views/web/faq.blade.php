@extends('web.master')
@section('body')
<div class="container mt-5">
    <h3 class="text-center mb-4">Frequently Asked Questions (FAQ)</h3>

    <div class="accordion" id="faqAccordion">
        @foreach($faqs as $index => $faq)
        <div class="accordion-item">
            <h2 class="accordion-header" id="heading{{ $index }}">
                <button class="accordion-button {{ $index == 0 ? '' : 'collapsed' }}" 
                        type="button" 
                        data-bs-toggle="collapse" 
                        data-bs-target="#collapse{{ $index }}" 
                        aria-expanded="{{ $index == 0 ? 'true' : 'false' }}" 
                        aria-controls="collapse{{ $index }}">
                    {{ $faq->question }}
                </button>
            </h2>
            <div id="collapse{{ $index }}" class="accordion-collapse collapse {{ $index == 0 ? 'show' : '' }}" 
                 aria-labelledby="heading{{ $index }}" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    {!! $faq->answer !!}
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Ensure Bootstrap JS is included -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<style>
    .accordion-button {
        font-weight: bold;
        background-color: #f8f9fa;
        color: #007bff;
    }

    .accordion-button:focus {
        box-shadow: none;
    }

    .accordion-button:not(.collapsed) {
        background-color: #007bff;
        color: #fff;
    }

    .accordion-body {
        font-size: 16px;
        color: #333;
        line-height: 1.6;
    }
</style>
@endsection
