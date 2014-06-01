#AWS Tutorial

##Obtaining the Code

1. You can download / clone / view the code on github
 - https://github.com/LoveSoftware/aws-tutorial

##Setting Up The VM and Companion Code

1. Install Virtual Box

2. Open Virtual Box 

3. Select "Import Appliance" from the "File" menu

4. Select the "Ubuntu-Aws" appliance from the open file dialoge

5. Click "Continue"

6. Tick the "Reinitialize MAC address box"

7. Click "Import"

8. After the import completes right click on the new VM

9. Click "Settings"

10. Click "Shared Folders"

11. Select the previously obtained source code folder

12. Click the Add Folder Icon

13. Click OK

14. Click OK

15. Start the VM. 

16. Log in using: U - awsuser P - password

17. Open a terminal

18. Mount the shared folder
 - sudo mount -t vboxsf -o uid=1000,gid=100 awstut /home/awsuser/awstut

##Configuring The CLI Tools

1. Log into the AWS Managment Console

2. Click Your Name in the upper right hand corner of the screen

3. Select "Security Credentials"

4. If it appears select "Continue to security credentials"

5. Click "Access Keys"

6. Click "Create New Access Key"

7. Click "Download Keyfile"

8. Download it to the shared folder

9. On the VM terminal
 - cat /home/awsuser/rootkey.csv

10. Configure the AWS CLI client
 - aws configure
 - enter the access key and secret key above
 - use "eu-west-1" as default region
 - leave default response format empty 

11. Test AWS CLI client
 - aws ec2 describe-regions

##Creating And Adding An SSH Key

1. Log into the AWS Managment Console

2. Select "EC2" from the services menu
 - Ensure you have the region "Ireland" selected, see upper left hand corner of the screen

3. Click "Key Pairs" on the left hand navigation menu

4. Click "Create Keypair"

5. Name the keypair

6. Download it to the shared folder

7. On the VM Terminal, add the key to your ssh-agent
 - ssh-add /home/awsuser/host/keyname.pem

