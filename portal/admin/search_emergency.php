<?php

include 'includes/connect.php';
// Retrieve the search parameters
$agency = $_POST['agency'];
$status = $_POST['status'];

// Build the SQL query based on the search parameters
$query = "SELECT e.*, a.agency_name 
          FROM emergency e 
          INNER JOIN agency a ON e.agency_id = a.agency_id 
          WHERE 1=1";

if (!empty($agency)) {
    $query .= " AND a.agency_name = '$agency'";
}

if (!empty($status)) {
    $query .= " AND e.status = '$status'";
}

// Execute the query and fetch the results
$result = $db->prepare($query);
$result->execute();

// Generate the HTML for the search results
$html = '';
for ($i = 1; $row = $result->fetch(); $i++) {
    $html .= '<tr class="text-center">';
    $html .= '<td class="text-center">' . $i . '</td>';
    $html .= '<td class="text-center">' . $row['emergency_id'] . '</td>';
    $html .= '<td class="text-center">' . $row['agency_name'] . '</td>';
    $html .= '<td class="text-center">' . $row['emergency_category'] . '</td>';
    $html .= '<td class="text-center">' . $row['address'] . '</td>';

    $html .= '<td class="text-center">';
    if ($row['status'] == "Pending") {
        $html .= '<p class="status-red">Ongoing</p>';
    } else {
        $html .= '<p class="status-green">Resolved</p>';
    }
    $html .= '</td>';
    $html .= '<td>' . $row['dates'] . '</td>';
    $html .= '<td class="text-center">';
    $html .= '<a class="btn btn-primary" href="make_action.php?id=' . $row['id'] . '"><i class="fa fa-eye"></i></a>';
    $html .= '<a class="btn btn-primary" href="delete_emergency.php?id=' . $row['id'] . '"><i class="fa fa-trash-o"></i></a>';
    $html .= '</td>';
    $html .= '</tr>';
}

// Return the search results HTML
echo $html;
?>
