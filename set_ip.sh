#!/bin/bash

NEW_IP=$1
NEW_NETMASK=$2
NEW_GATEWAY=$3

# Backup the current interfaces file
cp /etc/network/interfaces /etc/network/interfaces.bak

# Write new configuration to interfaces file
cat <<EOT > /etc/network/interfaces
auto lo
iface lo inet loopback

auto eth0
iface eth0 inet static
    address $NEW_IP
    netmask $NEW_NETMASK
    gateway $NEW_GATEWAY
EOT

# Restart networking to apply changes and capture output
sudo ip link set eth0 down
sudo ip addr flush dev eth0
sudo ip link set eth0 up
output=$(sudo systemctl restart networking 2>&1)
exit_code=$?

if [ $exit_code -ne 0 ]; then
    echo "Failed to restart networking: $output"
    exit $exit_code
else
    echo "Networking service restarted successfully."
    exit 0
fi

# Lighttpd script
