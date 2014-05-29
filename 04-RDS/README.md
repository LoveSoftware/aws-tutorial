#Creating An RDS Database

##Creating The Network Environment To Run RDS

Apply the cloud formation template 01-multiAZ.json as in previous excersies.

##Creating A RDS Subnet Group

1. Select "RDS" from the Services menue in the top right corner of the screen

2. Select "Subnet Groups" from the left hand navigation menu

3. Click "Create DB Subnet Group"

4. Input a name and desription

5. Select the VPC created by in the previous step
 - See VPC > Routing Tables for VPC and Subnet IDS

6. Add the private subnet from availability zones 1a and 1b

7. Click "Yes, Create"  

##Creating A RDS Instance

1. Select "Instances" from the left hand navigation menu

2. Click "Launch DB Instance"

3. Select "MYSQL"

4. Select: "No, this instance is intended for use outside of production or under the RDS Free Usage Tier"

5. Click "Next"

6. Chose the following options: 
 - DB Instance Class: db.t1.micro
 - Multi-AZ Deployment: No
 - Allocated Storage: 5
 - Use Provisioned IOPS: no
 - DB Instance Identifier: testdb
 - Master Username: awsuser
 - Master Password: password

7. Click "Next"

8. Choose the following Options: 
 - VPC: Select the VPC created above
 - VPC Security Groups: DB Security group created by cloud formation
 - Database Name: testdb

9. Click "Launch DB Instance"

##Connecting To The Db Instance

1. Open MySQL Workbench

2. Click "New Connection"

3. Name The Connection

4. On the "Connection Method" drop down select "Standard TCP/IP over SSH"

5. Input the following options:
 - SSH Hostname: IP address of the bastion server
 - SSH Username: ubuntu
 - SSH Keyfile: Location of testkey.pem
 - Mysql Hostname: Value of "Endpoint" field of DB instance created above
 - Mysql User: awsuser
 - Mysql Password: password

 