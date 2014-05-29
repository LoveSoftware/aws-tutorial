#Creating A Cloud Front Distribution Backed By S3

##Create an S3 bucket

1. Select "S3" from the service menu on the upper right hand side

2. Click "Create Bucket"

3. Give the bucket a name (this has to be unique across the region)

4. Click "Create"

5. Click "Actions" then "Upload"

6. Upload the test image in this folder

##Create a Cloud Front Distribution

1. Select "Cloud Front" from the services menu on the upper right hand side

2. Click "Create Distribution"

3. In the Origin Domain Name box select your previously created bucket

4. Click "Create Distribution"

5. Wait for the status to move from "InProgress" 

##Altering Your Bucket Permissions

1. Select "S3" from the service menu on the upper right hand side

2. Click your previously created bucket

3. Click "Properties" on the upper left hand side of the screen

4. Click "Permissions"

5. Click "Apply Bucket Policy"

6. Copy the policy from this folder into the text box, remembering to change the example bucket name to the name you created above. 

##Testing

1. Select "Cloud Front" from the services menu on the upper right hand side

2. Click the "i" button on your previously created cloud front distribution

3. Copy the "domain name" value and paste it into your browser. Add /php.png to the end and hit return

4. You should see the famous elephant