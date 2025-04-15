@extends('catalog.common.base')

@push('setTitle')
    Return/Replacement Policy
@endpush

@section('content')
<style>
    .policy_font{
        font-size: 14px
    }
</style>
    <section class="container p-4">
        <h1 class="mb-4 text-center"> Herculeen Return & Replacement Policy</h1>

        <p class="policy_font">At Herculeen, we prioritize customer satisfaction and are committed to providing a seamless shopping experience.
            If you are not fully satisfied with your purchase, here’s how we can assist:</p>
        <p class="policy_font">Key Points of the Policy:</p>
        <p class="policy_font">Return/Replacement Period: Customers can initiate a return or replacement request within 3 days from the date of delivery.</p>
        
        <h4>Conditions for Returns and Replacements:</h4>
        <ul>
            <li class="policy_font">The product must be unused, unwashed, and in its original condition.</li>
            <li class="policy_font">Tags, labels, and packaging should be intact.</li>
            <li class="policy_font">Proof of purchase (order confirmation or invoice) is required.</li>
        </ul>

        <h4>Non-Returnable Items:</h4>
        <ul>
            <li class="policy_font">Products showing signs of wear, intentional damage, or misuse after delivery will not be accepted.</li>
            <li class="policy_font">Customized or clearance sale items cannot be returned or replaced unless defective.</li>
        </ul>
        
        <h4>Process for Return/Replacement:</h4>
        <ul>
            <li class="policy_font">Customers can raise a request through our website or contact customer support.</li>
            <li class="policy_font">Herculeen will arrange a pick-up service or provide a return shipping label.</;>
        </ul>
        
        <h4>Refunds:</h4>
        <ul>
            <li class="policy_font">Refunds will be processed to the original payment method within 7-10 business days after the product is received
                and inspected.</li>
        </ul>

        <h4>Exchange Options:</h4>
        <ul>
            <li class="policy_font">Replacements are subject to stock availability. In case of unavailability, a full refund will be provided.</li>
        </ul>

        <h4>Note for a Smooth Return Process:</h4>
        <ul>
            <h5>To ensure a hassle-free return or replacement experience, we strongly recommend recording an unboxing video
                while opening your package. This video should clearly show:</h5>
    
            <ul>
                <li class="policy_font">The package in its original sealed condition.</li>
                <li class="policy_font">The opening process.</li>
                <li class="policy_font">The product received inside.</li>
                <li class="policy_font">The unboxing video serves as vital proof in case of any issues and helps us resolve your request more
                efficiently.</li>
            </ul>
        </ul>
    </section>
@endsection
