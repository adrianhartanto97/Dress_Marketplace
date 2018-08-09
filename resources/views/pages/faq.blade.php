@extends('layout')

@section('css')
    {{ HTML::style('public/pages/css/faq.css') }}
@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="tabbable-custom">
            <ul class="nav nav-tabs ">
                <li class="active">
                    <a href="#tab_1" data-toggle="tab"> Buyer </a>
                </li>
                <li>
                    <a href="#tab_2" data-toggle="tab"> Seller </a>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <div class="faq-page faq-content-1">
                        <div class="faq-content-container">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="faq-section ">
                                        <h2 class="faq-title uppercase font-blue">Registration</h2>
                                        <div class="panel-group accordion faq-content" id="accordion1">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        <i class="fa fa-circle"></i>
                                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapse_1"> How to become Buyer?</a>
                                                    </h4>
                                                </div>
                                                <div id="collapse_1" class="panel-collapse collapse">
                                                    <div class="panel-body">
                                                        <p> 
                                                            To become a buyer, you simply need to register, please visit <a href="http://localhost/dress_marketplace/login_page" target="_blank">http://localhost/dress_marketplace/login_page</a> then click "CREATE AN ACCOUNT"
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        <i class="fa fa-circle"></i>
                                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapse_2"> Can I transact without registering? </a>
                                                    </h4>
                                                </div>
                                                <div id="collapse_2" class="panel-collapse collapse">
                                                    <div class="panel-body">
                                                        <p> No, you must login first</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="faq-section ">
                                        <h2 class="faq-title uppercase font-blue">How to Shop ?</h2>
                                        <div class="panel-group accordion faq-content" id="accordion2">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        <i class="fa fa-circle"></i>
                                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse_3"> How do order or shop? </a>
                                                    </h4>
                                                </div>
                                                <div id="collapse_3" class="panel-collapse collapse">
                                                    <div class="panel-body">
                                                        <p> 
                                                            It is quite easy, just follow the steps below:
                                                            <ol>
                                                                <li>Search and choose dresses which you want to order</li>
                                                                <li>Click "Add to Bag" button</li>
                                                                <li>Then, Pop-up bag will appear</li>
                                                                <li>Fill the size Qty of dress, then click "Add to Bag"</li>
                                                                <li>You can view your shopping bag on the top corner of the page, click "View all" to view details</li>
                                                                <li>Click "Checkout" button to continue to payment</li>
                                                                <li>In the "Checkout" page, you will be directed to choose shipping address, please fill in the form</li>
                                                                <li>After that, continue by clicking "Continue".</li>
                                                                <li>Choose a courier service. In this step, you can leave a message to the seller. Then, click "Continue"</li>
                                                                <li>After that, you can use your Cash by fill the "use cash", then click "Submit"</li>
                                                                <li>Pay and confirm payment in "Confirm Payment" on "Purchase" Menu</li>
                                                            <ol>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        <i class="fa fa-circle"></i>
                                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse_4"> How can I confirm payment and how long does it take? </a>
                                                    </h4>
                                                </div>
                                                <div id="collapse_4" class="panel-collapse collapse">
                                                    <div class="panel-body">
                                                        <p> 
                                                            Payment confirmation can be done through "Payment" tab located at "Purchase" menu. Payment confirmation will take 1x12 office hours)
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        <i class="fa fa-circle"></i>
                                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse_5"> How can I track my order status? </a>
                                                    </h4>
                                                </div>
                                                <div id="collapse_5" class="panel-collapse collapse">
                                                    <div class="panel-body">
                                                        <p> 
                                                            To track your order status, you can find it at "Order Status" tab in "Purchase" Menu
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="faq-section ">
                                        <h2 class="faq-title uppercase font-blue">Request for Quotation</h2>
                                        <div class="panel-group accordion faq-content" id="accordion3">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        <i class="fa fa-circle"></i>
                                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapse_6"> When Can I Make a Quotation Request?</a>
                                                    </h4>
                                                </div>
                                                <div id="collapse_6" class="panel-collapse collapse">
                                                    <div class="panel-body">
                                                        <p> 
                                                            You can request for a quotation if you have been looking for dress in any source in Indonesia or abroad but feel less suitable with price, quality of goods, type of goods, shipping , etc. You can start doing a Quotation Request here. 
                                                            Visit page <a href="http://localhost/dress_marketplace/request_for_quotation" target="_blank">http://localhost/dress_marketplace/request_for_quotation</a>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="faq-section ">
                                        <h2 class="faq-title uppercase font-blue">Financial</h2>
                                        <div class="panel-group accordion faq-content" id="accordion6">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        <i class="fa fa-circle"></i>
                                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion6" href="#collapse_7"> what affects my cash balance?</a>
                                                    </h4>
                                                </div>
                                                <div id="collapse_7" class="panel-collapse collapse">
                                                    <div class="panel-body">
                                                        <p> 
                                                            Debit :
                                                            <ol>
                                                                <li>Sales Transaction from your Store</li>
                                                                <li>Change money from Accepted Payment</li>
                                                                <li>Rejected Payment</li>
                                                                <li>Change money from Rejected Order Product</li>
                                                            </ol>
                                                        </p>
                                                        <p> 
                                                            Credit :
                                                            <ol>
                                                                <li>Use Cash</li>
                                                                <li>Withdraw</li>
                                                            </ol>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="tab_2">
                    <div class="faq-page faq-content-1">
                        <div class="faq-content-container">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="faq-section ">
                                        <h2 class="faq-title uppercase font-blue">Registration</h2>
                                        <div class="panel-group accordion faq-content" id="accordion4">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        <i class="fa fa-circle"></i>
                                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion4" href="#collapse_11"> How to open store?</a>
                                                    </h4>
                                                </div>
                                                <div id="collapse_11" class="panel-collapse collapse">
                                                    <div class="panel-body">
                                                        <p> 
                                                            Please Follow this steps:
                                                            <ol>
                                                                <li>Click "Open Store" button</li>
                                                                <li>Input your Store Name. You can check name availability by clik "Check Store Name"</li>
                                                                <li>Click "Continue"</li>
                                                                <li>Fill your store information, include upload legal documents (KTP, SIUP, NPWP, SKDP, TDP). Then clik "Continue"</li>
                                                                <li>Checklist on courier services that you provide. Then click "Continue"</li>
                                                                <li>Confirm your store information. Then click "Submit"</li>
                                                            </ol>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="faq-section ">
                                        <h2 class="faq-title uppercase font-blue">Order</h2>
                                        <div class="panel-group accordion faq-content" id="accordion5">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        <i class="fa fa-circle"></i>
                                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion5" href="#collapse_12"> How is the ordering process?</a>
                                                    </h4>
                                                </div>
                                                <div id="collapse_12" class="panel-collapse collapse">
                                                    <div class="panel-body">
                                                        <p> 
                                                            Order process happens when buyers check out, place the order and pay. Then, order notification will be shipped to the seller panel. After that, the fund from the buyer will be shipped to the seller after the buyer has already confirmed the received dress.
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="faq-section ">
                                        <h2 class="faq-title uppercase font-blue">Financial</h2>
                                        <div class="panel-group accordion faq-content" id="accordion7">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        <i class="fa fa-circle"></i>
                                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion7" href="#collapse_13"> what affects my cash balance?</a>
                                                    </h4>
                                                </div>
                                                <div id="collapse_13" class="panel-collapse collapse">
                                                    <div class="panel-body">
                                                        <p> 
                                                            Debit :
                                                            <ol>
                                                                <li>Sales Transaction from your Store</li>
                                                                <li>Change money from Accepted Payment</li>
                                                                <li>Rejected Payment</li>
                                                                <li>Change money from Rejected Order Product</li>
                                                            </ol>
                                                        </p>
                                                        <p> 
                                                            Credit :
                                                            <ol>
                                                                <li>Use Cash</li>
                                                                <li>Withdraw</li>
                                                            </ol>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </di>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

