<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'includes/header.php';
?>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <h1 class="display-4 mb-4">Size Guide</h1>
            <p class="lead">Find the perfect fit with our comprehensive size guide.</p>
            
            <div class="card border-0 shadow-sm mb-5">
                <div class="card-body">
                    <h2 class="h3 mb-4">General Sizing Information</h2>
                    <p>
                        Our shoes are true to size, but we recommend checking the specific sizing chart for each product 
                        as fit may vary slightly between styles. If you're between sizes or unsure, we recommend sizing up.
                    </p>
                    <p>
                        For the most accurate measurement, stand barefoot on a piece of paper and mark the longest part 
                        of your foot (usually the big toe) and the back of your heel. Measure this distance in centimeters 
                        and compare to our size chart.
                    </p>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h3 class="h5 mb-0">Men's Shoe Sizes</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>US Size</th>
                                            <th>EU Size</th>
                                            <th>UK Size</th>
                                            <th>Foot Length (cm)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr><td>7</td><td>40</td><td>6</td><td>25.1</td></tr>
                                        <tr><td>8</td><td>41</td><td>7</td><td>26.0</td></tr>
                                        <tr><td>9</td><td>42</td><td>8</td><td>26.8</td></tr>
                                        <tr><td>10</td><td>43</td><td>9</td><td>27.6</td></tr>
                                        <tr><td>11</td><td>44</td><td>10</td><td>28.5</td></tr>
                                        <tr><td>12</td><td>45</td><td>11</td><td>29.4</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h3 class="h5 mb-0">Women's Shoe Sizes</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>US Size</th>
                                            <th>EU Size</th>
                                            <th>UK Size</th>
                                            <th>Foot Length (cm)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr><td>5</td><td>35</td><td>3</td><td>22.1</td></tr>
                                        <tr><td>6</td><td>36</td><td>4</td><td>22.9</td></tr>
                                        <tr><td>7</td><td>37</td><td>5</td><td>23.8</td></tr>
                                        <tr><td>8</td><td>38</td><td>6</td><td>24.6</td></tr>
                                        <tr><td>9</td><td>39</td><td>7</td><td>25.4</td></tr>
                                        <tr><td>10</td><td>40</td><td>8</td><td>26.2</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h2 class="h3 mb-3">Width Guide</h2>
                    <p>
                        Our standard width is Medium (M) for both men and women. We also offer some styles in Wide (W) 
                        and Extra Wide (XW) options. If you have particularly wide or narrow feet, please check the 
                        product description for available widths.
                    </p>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>Width</th>
                                    <th>Men's Designation</th>
                                    <th>Women's Designation</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td>Narrow</td><td>B</td><td>AA</td><td>Fits narrow feet</td></tr>
                                <tr><td>Medium</td><td>D</td><td>B</td><td>Standard width</td></tr>
                                <tr><td>Wide</td><td>EE</td><td>D</td><td>Fits wide feet</td></tr>
                                <tr><td>Extra Wide</td><td>EEE</td><td>EE</td><td>Fits extra wide feet</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h2 class="h3 mb-3">Still Unsure About Your Size?</h2>
                    <p>
                        If you're still unsure about which size to order or have specific fitting questions, 
                        our customer service team is happy to help. Please <a href="contact.php">contact us</a> 
                        with your measurements and the style you're interested in, and we'll recommend the best size for you.
                    </p>
                    <p class="mb-0">
                        Remember, we offer free returns and exchanges if the size isn't quite right, so you can shop with confidence.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
require_once 'includes/footer.php';
?>