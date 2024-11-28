<?php
include(__DIR__ . '/../include/functions.php');
include(__DIR__ . '/../include/vars.php');

// Get POST data
$vendor = isset($_POST['vendor']) ? $_POST['vendor'] : '';
$hostname = isset($_POST['hostname']) ? $_POST['hostname'] : '';
$ip = isset($_POST['ip']) ? $_POST['ip'] : '';
$subnetmask = isset($_POST['subnetmask']) ? $_POST['subnetmask'] : '';
$defaultgateway = isset($_POST['defaultgateway']) ? $_POST['defaultgateway'] : '';
$routing_enabled = isset($_POST['routing_enabled']) ? $_POST['routing_enabled'] : '';
$stp_mode = isset($_POST['stp_mode']) ? $_POST['stp_mode'] : '';

// Generate configuration based on vendor
switch($vendor) {
    case 'juniper_junos':
        // Hostname
        echo "set system host-name $hostname\n";
        
        // Interface configuration
        echo "set interfaces vme unit 0 family inet $ip/$subnetmask\n";
        
        // Routing configuration if enabled
        if ($routing_enabled == 'yes') {
            echo "set routing-options static route 0.0.0.0/0 next-hop $defaultgateway\n";
        }
        
        // RSTP configuration
        if ($stp_mode == 'rstp') {
            echo "set protocols rstp\n";
        }
        break;
        
    case 'cisco_ios':
        echo "hostname $hostname\n";
        echo "interface vlan 1\n";
        echo "  ip address $ip $subnetmask\n";
        echo "  no shutdown\n";
        
        if ($routing_enabled == 'yes') {
            echo "ip routing\n";
            echo "ip route 0.0.0.0 0.0.0.0 $defaultgateway\n";
        }
        
        if ($stp_mode == 'rstp') {
            echo "spanning-tree mode rapid-pvst\n";
        } else {
            echo "spanning-tree mode pvst\n";
        }
        break;
        
    case 'nortel':
        // Nortel config generation
        echo "# Nortel Configuration\n";
        echo "# Generated on " . date('Y-m-d H:i:s') . "\n\n";
        // Add your Nortel config generation code here
        break;
        
    default:
        echo "Error: Unknown vendor type";
}
?>
