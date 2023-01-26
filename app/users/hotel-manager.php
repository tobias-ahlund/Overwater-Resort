<?php

session_start();

$authenticated = $_SESSION['authenticated'] ?? false;

require "./addFeatures.php";

// Magnus V. - The logic for adding new features here:
if (isset($_POST['feature-name'], $_POST['feature-price'])) :
    $featureName = htmlspecialchars(trim($_POST['feature-name'], ENT_QUOTES));;
    $featurePrice = (int)htmlspecialchars($_POST['feature-price'], FILTER_SANITIZE_NUMBER_INT);

    // Magnus V. - Conecting to bookings.db:
    $path = '../../';
    $connectBookingsDatabase = connectBookingsDatabase($path);
    // Magnus V. - Adding the new feature to database:
    addFeatureToDatabase($featureName, $featurePrice, $connectBookingsDatabase);

endif;

?>
<div class="page-wrapper">
    <?php

    if (!$authenticated) : header("location: ../../index.php");
    endif;

    require "../../header.php";
    ?>

    <!-- SECTION FEATURES-LIST -->
    <section class="features-space">

        <div class="feature-list">
            <h3>Current extra features</h3>
            <br>
            <ol>
                <?php
                $path = '../../';
                $connectBookingsDatabase = connectBookingsDatabase($path);

                $currentExtraFeatures = getFeaturesFromDatabase($connectBookingsDatabase);

                foreach ($currentExtraFeatures as $featureNr => $feature) :

                    echo '<li>' . $feature['feature_name'] . ':  ' . $feature['feature_cost'] . '$ / Day</li>';

                endforeach;
                ?>
            </ol>
        </div>

    </section>

    <!-- SECTION ACTIONS-SPACE -->
    <section class="actions-space">

        <div class="feature-handler-wrapper">
            <div class="button-container">
                <button class="actions-space-button" id="add-new-feature">Add new feature</button>
            </div>

            <div id="add-feature-field" class="drop-down-field">
                <form class="feature-handler" action="./hotel-manager.php" method="post">

                    <!-- Feature name-field -->
                    <div class="label-container">
                        <label for="feature-name">Feature name</label>
                    </div>
                    <input id="feature-name" type="text" name="feature-name" placeholder="(Feature's name)" required>

                    <!-- Field for feature price -->
                    <div class="label-container">
                        <label for="feature-price">The feature's price</label>
                    </div>
                    <!-- Min-value of "1" is set here -->
                    <input id="feature-price" type="number" min="1" name="feature-price" placeholder="(Price in $)" required>

                    <div class="break"></div>

                    <div class="button-container">

                        <!-- One button used for submitting the feature, the other for resetting and hiding the field -->
                        <button id="feature-submit-button" type="submit">Add feature</button>
                        <button id="cancel-button" type="reset">Cancel</button>
                    </div>
                </form>
            </div>
            </form>
        </div>
        <div class="feature-handler-wrapper">
            <div class="button-container">
                <button class="actions-space-button">Remove feature (due to be implemented)</button>
            </div>
            <form class="feature-handler" action="./hotel-manager.php" method="post"></form>
        </div>
    </section>

    <script src="../../loginScript.js"></script>
    <script src="../../hotelManagerScript.js"></script>

    <?php
    require "../../footer.php";
    ?>

</div>
