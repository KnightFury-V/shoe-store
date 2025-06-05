<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'includes/header.php';
?>
 
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <h1 class="faq-heading">Frequently Asked Questions</h1>
 
 
            <link rel="stylesheet" href="/shoe-store/assets/css/faq.css">
            <div class="accordion" id="faqAccordion">
                <!-- Order Questions -->
                <div class="card mb-3">
                    <div class="card-header" id="headingOne">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                How do I place an order?
                            </button>
                        </h2>
                    </div>
                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#faqAccordion">
                        <div class="card-body">
                             <ul>
                             <li>Placing an order is easy.</li>
                             <li>Browse our products, add to cart, and checkout.</li>
                             <li>You can checkout as guest or register for faster access later.</li>
                             </ul>
                        </div>
                    </div>
                </div>
               
                <!-- Shipping Questions -->
                <div class="card mb-3">
                    <div class="card-header" id="headingTwo">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                What are your shipping options?
                            </button>
                        </h2>
                    </div>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#faqAccordion">
                        <div class="card-body">
                             <ul>
                             <li>Standard Delivery: 3–5 business days</li>
                             <li>Express Delivery: 1–2 business days</li>
                             <li>Pick-Up Option from our location</li>
                             <li>Note: Pick-up orders must be paid at the location</li>
                              </ul>
 
                          Note: If you select pick-up, payment must be made at the pick-up location. Online payments are not available for pick-up orders.
 
                       
                        </div>
                    </div>
                </div>
               
                <!-- Returns Questions -->
                <div class="card mb-3">
                    <div class="card-header" id="headingThree">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                What is your return policy?
                            </button>
                        </h2>
                    </div>
                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#faqAccordion">
                        <div class="card-body">
                            You can return items within 30 days of purchase, as long as they are:
                            <ul>
 
                          <li> 1. Unworn </li>
 
                           <li>2. In original packaging </li>
 
                           <li>3. With tags attached </li>
                          </ul>
                             
                        </div>
                    </div>
                </div>
               
                <!-- Size Questions -->
                <div class="card mb-3">
                    <div class="card-header" id="headingFour">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                How do I know what size to order?
                            </button>
                        </h2>
                    </div>
                    <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#faqAccordion">
                        <div class="card-body">
                            Use our  <a href="/size-guide.php">Size Guide</a> or refer to the size chart on each product page to find your perfect fit.
                           
                        </div>
                    </div>
                </div>
               
                <!-- Payment Questions -->
                <div class="card mb-3">
                    <div class="card-header" id="headingFive">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                What payment methods do you accept?
                            </button>
                        </h2>
                    </div>
                    <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#faqAccordion">
                        <div class="card-body">
                            <ul>
                           <li> We accept major credit cards (Visa, MasterCard, American Express), PayPal, and Apple Pay at Pickup Location.</li> 
                          <li>All transactions are processed securely.</li>
                         </ul>
                           
                        </div>
                    </div>
                </div>
               
                <!-- Account Questions -->
                <div class="card mb-3">
                    <div class="card-header" id="headingSix">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                How do I reset my password?
                            </button>
                        </h2>
                    </div>
                    <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#faqAccordion">
                        <div class="card-body">
                           
                            <ul>
 
                          <li>1. To reset your password, please follow these steps:</li>
 
                         <li> 2. Log in to your account.</li>
 
                          <li>3. Go to your Profile.</li>
 
                          <li>4. Select Reset Password or Change Password.</li>
 
                          <li>5. Follow the prompts to enter your current password and create a new one.</li>
 
                          <li>6. Save your changes.</li>
 
 
                         <p>If you experience any issues, please <a href="/shoe-store/contact.php">Contact Us for assistance.</a> </p>
                         </ul>
                           
                        </div>
                    </div>
                </div>
            </div>
           
            <div class="mt-5 bg-light p-4 rounded">
                <h3 class="h4">Still have questions?</h3>
                <p>
                    We’re here to help.
                    <a href="/shoe-store/contact.php">Contact Us</a>We'll be happy to assist you!
                </p>
            </div>
        </div>
    </div>
</div>
 
 
 
<?php
require_once 'includes/footer.php';
?>