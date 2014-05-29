#Simple Architecture Tutorial

1. Go to the AWS Managment Console http://console.aws.amazon.com/ and sign in.

2. Select "EU (Ireland)" from the regions menu in the top right hand corner. 

## Creating A VPC

1. Select "VPC" from the services in the middle pane.

2. Select "Your VPCs" from the left hand sub menu.

3. Click the Blue "Create VPC" button.

4. Input a name for your VPC.

5. Input a CIDR block your VPC will use - 10.0.0.0/16.

6. Click the "Yes, Create" button.

## Creating Public / Private Subnets

From the VPC screen:

1. Click "Subnets" on the left hand navigation menu

2. Click "Create Subnet"

3. Enter "public" in the name box

4. Select the previously created VPC from the drop down menu

5. Select "eu-west-1a" from the "Availability Zone" drop down menu

6. Choose a CIDR block your VPC will use - 10.0.1.0/24

Repeat the process above creating a "private" subnet with CIDR "10.0.2.0/24"

## Creating An Internet Gateway and Routing Table

From the VPC Screen: 

1. Click "Internet Gateways" on the left hand navigation menu

2. Click "Create Internet Gateway"

3. Name the gateway "TEST GATEWAY"

4. Click the newly created gateway

5. Click the "Attach To VPC" button

6. Select the previously created VPC from the drop down

7. Click "Route Tables" from the left hand navigation menu

8. Click on the route table associated with your VPC (created by default when creating a VPC)

9. In the bottom detail pane select the "Routes" tab

10. Click "Edit"

11. Add a new route. Destination 0.0.0.0/0, Target (select newly created Gateway).

12. Click "Save"

13. Click "Create Route Table"

14. Enter the name "private" and select the previously created VPC and click "Yes, Create"

15. Select the previously created route table

16. In the bottom pane select "Subnet Associations" and click "Edit"

17. Tick the "Associate" box next to the previosuly created "private" subnet and click "Save"

## Creating Security Groups

From the VPC Screen:

1. Click "Security Groups" on the left hand navigation menu

2. Click "Create Security Group"

3. Name the security group "test-web"

4. Add a simple description

5. Select the previously created VPC from the VPC drop down

6. Click "Yes, Create"

7. Click the newly created security group

8. In the detail pane click "Inbound Rules"

9. Add two rules to allow http and https traffic from anywhere and click "create"
 - Type: HTTP / HTTPS
 - Protocol: TCP
 - Source: 0.0.0.0/0

10. Repeat this process and create a security group called test-bastion.
 - Type: SSH
 - Protocol: TCP
 - Source: 0.0.0.0/0

11. Create a security group test-admin. Add a rule for SSH traffic. Select "custom ip" from the source drop down. Enter "sg-" to get a list of available groups. Select the group "test-bastion".

12. Create another security group called test-nat. 
 - Type: SSH
 - Protocol: TCP
 - Source: 10.0.0.0/16

## Adding A NAT 

1. Select "EC2" from the "Services" menu 

2. Click "Instances" 

3. Click "Launch Instance"

4. Click "Community AMIs"

5. Enter "ami-f3e30084" into the search box and hit return

6. Click "Select"

7. Click "Instance Details"

8. Change the following: 
  - Network: Choose previously created VPC
  - Subnet: Choose "public"
  - Tick "Automatically assign public IP"

9. Click "Next: Add Storage"

10. Click "Next: Tag Instance"

11. Name the instance "TEST NAT"

12. Click "Next: Configure Security Group"

13. Click "Select An Existing Security Group" and tick the two previously created groups "test-nat" and "test-admin"

14. Click "Review and Launch"

15. Click "Launch"

16. From the drop down select "Create a new key pair"

17. Name the pair "test" and click "Download Key Pair". Save the key pair somehwere easily acessable.

18. Click "Launch Instances"

19. Click "View Instances"

NAT instances need an option toggling to enable them to function as NATs

20. Right click the NAT instance

21. Click "Change Source/Dest. Check"

22. Click Disable

Traffic from the private subnet must now be routed through the newly created NAT.

23. Select "VPC" from the services menu in the upper right hand corner of the screen.

24. Select "Route Tables" from the left hand nav

25. Select the "Private" route table

26. Select "Routes" from the bottom pane

27. Click "Edit"

28. Add an additional route with the destination "0.0.0.0/0" and select the NAT instance from the "target" drop down.

29. Click "Save"

## Creating a Bastion Host

Repeat the process of launching an instance as above:
 - AMI: ami-896c96fe
 - Security Groups: test-bastion
 - Use existing key created above

On the instances screen:

1. Select the instance created in the previous step

2. Wait for the instance "Status Checks" in the top pane to hit "2/2 Checks Passed" (refresh until)

3. Copy the public IP address from the bottom pane

4. SSH into the instance: 
  - ssh -i /path/to/test.pem ubtunu@PUBLIC-IP-ADDRESS

You will now use this host as the gateway to instances in your private subnet

## Creating An Elastic Load Balancer

1. Select "EC2" from the "Services" menu 

2. Click "Load Balancers" on the left hand navigation menu

3. Click "Create Load Balancer" 

4. Name the elb "test-elb"

5. Select your previously created VPC from the "Create LB Inside" drop down

6. Click "Continue"

7. Make the following changes to the health check:
  - Health Check Interval: 10s
  - Healthy Threshold: 2

8. Click "Continue"

9. Click the "+" icon next to your public subnet

10. Click "Continue"

11. Untick the "default" security group and tick the "test-web" security group

12. Click "Continue"

13. Click "Create"

14. Click "Close"

## Launching A Webserver

Repeat the process of launching an instance as above:
 - AMI: ami-896c96fe
 - Choose Private Subnet
 - DO NOT TICK ASSOCIATE PUBLIC IP
 - Security Groups: test-web, test-admin
 - Use existing key created above

## Configuring The Webserver

On the instances screen:

1. Select the instance created in the previous step

2. Wait for the instance "Status Checks" in the top pane to hit "2/2 Checks Passed" (refresh until)

3. Copy the private IP address of the webserver from the bottom pane

5. SSH into the bastion host as above

4. SSH into the instance: 
  - ssh ubtunu@PRIVATE-IP-ADDRESS

You are now logged into the new webserver box. 

5. Install apache2
  - sudo apt-get update
  - sudo apt-get install apache2

## Adding the new instance to the load balancer

From the EC2 Screen: 

1. Click "Load Balancers" on the left hand navigation menu

2. Select your previously created load balancer

4. In the bottom pane select "Instances"

5. Click "Edit Instances"

6. Check the box next to your previously created instance and click "Save"

7. In the bottom pane select "Description"

8. Copy the "DNS Name" field and paste it into the browser. You should see the default apache page.


## Creating An AMI

From the EC2 Screen:

1. Right click on the previously created webserver instance

2. Click "Create Image"

3. Add a name and description for the image

4. Click "Create Image"

5. Click "Amis" from the left hand navigation menu

6. Wait for the new AMI's status to switch to "available"

## Adding Autoscaling

From the EC2 Screen:

1. Delete the previously ceated webserver

2. Select "Launch COnfigurations" from the left hand Nav

3. Click "Create Auto Scaling Group"

4. Click "Create Launch Configuration"

5. Click "My AMIs"

6. Select your previously created AMI

7. Click "Next Configure Details"

8. Name the Launch config

9. Select "Advanced Details"

10. Click "Do not assign a public IP address to any instances."

11. Click "Next: Add Storage"

12. Click "Next: Security Groups"

13. Click "Select an existing security group"

14. Select the groups: test-admin, test-web

15. Click "Create Launch Configuration"

16. Select your previously created key

17. Name the Auto Scaling Group

18. Adjust "Group Size" to 2

19. Select your previously created VPC and private subnet

20. Click "Advanced Details"

21. In the "Load Balancing" field select your previously created ELB

22. Click "Next: Configure Scaling Policies"

23. Click: "Next: Configure Notifications"

24. Click: "Next: Configure Tags"

25. Click: "Review" 

26. Click: "Create Auto Scaling Group"

27. Click: "Close"