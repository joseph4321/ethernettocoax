# Ethernet to Coax

This code was written to manage the large number of moca (Multimedia Over Coax) devices that were used for properties that had an existing coax infrastructure and did not want to run new copper cabling.  These devices converted ip traffic over ethernet, to a TDM signal over coax, back to ethernet at the end device in the guest room, where the payload was delivered to the set top box.

Each NC head-end device had multiple CPE guest room devices that connected to it.  Since properties rarely had accurate information available describing their coax infrastructure, the application automatically discovered which NC each CPE connected to as the CPE's were installed in the guest room (this functionality is provided by the "Start Engine" button on the bottom).  Once new devices were discovered (show up in the web interface), it was a simple click to reconfigure the NC and CPE to work nicely together and provide network access to the guest room.  The application also provided:
- IP of the NC device
- Physical location of the device (rack and label number)
- Signal strength of the device over the coax cable
- Frequency of the devices on the coax cable
- Ping a device
- Reset a device configuration
- Reboot a device
- Auto discover NC to CPE mapping
- Warning if a head-end NC has too many CPE devices attached to it (which would degrade service)
- Get information for an NC device, such as uptime and logs
- Historical notes for devices to keep track of recurring issues
- Email alerts for when a device became unreachable

Demo video of the application can be found <a href="https://www.youtube.com/watch?v=FAD7-cYYyZc">here</a>

Programming languages used: perl (backend), php (frontend), javascript (frontend)
OS: CentOS 6.3

<img src="https://raw.githubusercontent.com/joseph4321/ethernettocoax/master/shot1.png" alt="Drawing" style="width: 400px;height: 400px"/>
