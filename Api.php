<?php 

	require_once 'dbConnect.php';
	
	//an array to display response
	$response = array();
	$server_response = array();
	
	//if it is an api call 
	//that means a get parameter named api call is set in the URL 
	//and with this parameter we are concluding that it is an api call

	if(isset($_GET['apicall'])){
		
		switch($_GET['apicall']){
			
			//pet owner singup............................................................
			case 'signup':
				//checking the parameters required are available or not 
				
                    //getting the values 
                    $name = $_POST['name'];
                    $username = $_POST['username']; 
                    $password = ($_POST['password']);
                    $address = $_POST['address'];
                    $email = $_POST['email']; 
                    $mobile = $_POST['mobile'];
                    $id = $_POST['id'];
                    $imageURL = $_POST['imageURL'];
						
						//if user is new creating an insert query 
						$stmt = "INSERT INTO pet_owners(id,name,username,password,address,mob_no,email,imageurl) VALUES('$id','$name','$username','$password','$address','$mobile','$email','$imageURL')";											//$stmt->bind_param($id,$name,$username,$password,$address,$mobile,$email,$imageURL);
						
						if(mysqli_query($conn ,$stmt)){
						echo "data insertion succeeded";
						 
						}
						else{
							echo "Data insertion error".mysqli_error($conn);
						}	
												
			break;
			
			//update pet owner dp.................................................................................
			case 'updatedp':
						$imageURL =  $_POST['imageURL'];
						$id = $_POST['id'];

						//query to update  DP
						$stmt = "UPDATE pet_owners SET imageurl='$imageURL' WHERE id='$id'";

						if(mysqli_query($conn ,$stmt)){
							echo "photo is updated";
							
							}
							else{
								echo "Somethiing error while uploading photo!".mysqli_error($conn);
							}	

			break;

			//view pet owner dp.........................................................................................
			case 'viewdp':
				$id = $_POST['id'];

				//query to view owner photo
				$query = mysqli_query($conn,"SELECT imageurl FROM pet_owners WHERE id=$id");

				if($query){
					while($row=mysqli_fetch_array($query)){
						$flag[]=$row;
					}
				print(json_encode($flag));
				}	
				break;
			

			//get pet owner details..............................................................................
			case 'view':
				$id = $_GET['id'];

				$query = mysqli_query($conn,"SELECT name,username,password,email,mob_no,address FROM pet_owners WHERE id='".$_GET['id']."'");

				if($query){
					while($row=mysqli_fetch_array($query)){
						$flag[]=$row;
					}
				print(json_encode($flag));
				}
						
				break;

			//update pet owner profile...............................................................................
			case 'update':
                    //getting the values 
                    $name = $_POST['name'];
                    $username = $_POST['username']; 
                    $password = ($_POST['password']);
                    $address = $_POST['address'];
                    $email = $_POST['email']; 
                    $mobile = $_POST['mobile'];
                    $id = $_POST['id'];
						
						//update query
					$stmnt = "UPDATE pet_owners SET name = '$name',username='$username',password='$password',address='$address',email='$email',mob_no='$mobile' WHERE id = $id";
						if(mysqli_query($conn ,$stmnt)){
							
							echo "data updated";
						 
						}
						else{
							echo "Data update error".mysqli_error($conn);
						}	
							
				break;
			
			default: 
				$response['error'] = true; 
				$response['message'] = 'Invalid Operation Called';
		}
		
	}else{
		//if it is not api call 
		//pushing appropriate values to response array 
		$response['error'] = true; 
		$response['message'] = 'Invalid API Call';
	}
	
	//displaying the response in json structure 
	//echo json_encode($response);
?> 

