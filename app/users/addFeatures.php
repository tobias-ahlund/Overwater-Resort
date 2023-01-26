<?php

declare(strict_types=1);

// Magnus V. - Connecting to bookings.db (to get access to extra_features-table):
function connectBookingsDatabase($path)
{
    try {
        $dbh = new PDO('sqlite:' . $path . 'bookings.db');
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo 'Connection failed:';
        throw $e;
    }
    return $dbh;
};

//Magnus V. - This function fetches the extra features parameters as an array from the extra_fetures-teble
function getFeaturesFromDatabase($dbh): array
{
    $getFeatureQuery =  'SELECT * from extra_features';

    $getFeatureStmt = $dbh->query($getFeatureQuery);
    $currentFeatures = $getFeatureStmt->fetchAll(PDO::FETCH_ASSOC);

    return $currentFeatures;
};

// Magnus V. - This function adds the new feature in extra_features-table:
function addFeatureToDatabase(string $featureName, int $featureCost, $dbh): void
{
    $addFeatureQuery =  'INSERT INTO extra_features (feature_name, feature_cost) VALUES (:feature_name, :feature_cost)';

    $insertIntoDb = $dbh->prepare($addFeatureQuery);
    $insertIntoDb->bindParam(':feature_name', $featureName, PDO::PARAM_STR);
    $insertIntoDb->bindParam(':feature_cost', $featureCost, PDO::PARAM_INT);

    $insertIntoDb->execute();

    header('location: ./hotel-manager.php');
};

// Magnus V. - This function writes out the added features with a check-button:
function writeExtraFeatures($path): void
{
    $dbh = connectBookingsDatabase($path);

    $currentExtraFeatures = getFeaturesFromDatabase($dbh);

    foreach ($currentExtraFeatures as $featureNr => $features) :
?>
        <div>
            <!-- Magnus V. - str_replace is used to replace empty spaces in the feature name, so it can be used in the "name"- and "id"-parameters: -->
            <input type="checkbox" value="<?= $features['feature_cost'] ?>" name="<?= str_replace(" ", "-", strtolower($features['feature_name'])) . "[]" ?>" id="extras-<?= str_replace(" ", "-", strtolower($features['feature_name'])) ?>"> <?= $features['feature_name'] . ':  ' . $features['feature_cost'] . '$ / Day' ?>
        </div>
<?php
    endforeach;
};
