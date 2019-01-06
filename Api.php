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
			
			case 'signup':
				//checking the parameters required are available or not 
				
                    //getting the values 
                    $name = $_POST['name'];
                    $username = $_POST['username']; 
                    $password = md5($_POST['password']);
                    $address = $_POST['address'];
                    $email = $_POST['email']; 
                    $mobile = $_POST['mobile'];
                    $id = $_POST['id'];
                    $imageURL = $_POST['imageURL'];
						
						//if user is new creating an insert query 
						$stmt = "INSERT INTO pet_owners(id,name,username,password,address,mob_no,email,imageurl) VALUES('$id','$name','$username','$password','$address','$mobile','$email','$imageURL')";											//$stmt->bind_param($id,$name,$username,$password,$address,$mobile,$email,$imageURL);
						echo "name";
						if(mysqli_query($conn ,$stmt)){
						echo "data insertion succeeded";
							//adding the user data in response 
							$response['error'] = false; 
							$response['message'] = 'User registered successfully'; 
						}
						else{
							echo "Data insertion error".mysqli_error($conn);
						}	
						echo json_encode($response);
				
				
			break;
			
			case 'updatedp':
						$imageURL =  $_POST['imageURL'];
						$id = $_POST['id'];

						//query to update  DP
						$stmt = "UPDATE pet_owners SET imageurl='$imageURL' WHERE id='$id'";

						if(mysqli_query($conn ,$stmt)){
							echo "data insertion succeeded";
								//adding the user data in response 
								$response['error'] = false; 
								$response['message'] = 'Photo uploaded successfully'; 
							}
							else{
								echo "Somethiing error while uploading photo!".mysqli_error($conn);
							}	

			break;

			case 'viewdp':
				$id = $_POST['id'];

				//query to view owner photo
				$stmt = "SELECT imageurl FROM pet_owners WHERE id='$id';";

				$result = mysqli_query($conn ,$stmt);
				while($row = mysqli_fetch_array($result)){
					$response = ["image"->$row[0]];	
					array_push($server_response,$response);	
				}
				echo json_encode($server_response);
						
				break;
			
			case 'login':
				//for login we need the username and password 
					//getting values 
					$username = $_POST['username'];
					$password = md5($_POST['password']);
					$email;
					$gender; 
					
					//creating the query 
					$stmt = $conn->prepare("SELECT id, username, email, gender FROM users WHERE username = ? AND password = ?");
					$stmt->bind_param("ss",$username, $password);
					
					$stmt->execute();
					
					$stmt->store_result();
					
					//if the user exist with given credentials 
					if($stmt->num_rows > 0){
						
						$stmt->bind_result($id, $username, $email, $gender);
						$stmt->fetch();
						
						$user = array(
							'id'=>$id, 
							'username'=>$username, 
							'email'=>$email,
							'gender'=>$gender
						);
						
						$response['error'] = false; 
						$response['message'] = 'Login successfull'; 
						$response['user'] = $user; 
					}else{
						//if the user not found 
						$response['error'] = false; 
						$response['message'] = 'Invalid username or password';
					}
					echo json_encode($response);
				
			break; 

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
			case 'update':
                    //getting the values 
                    $name = $_POST['name'];
                    $username = $_POST['username']; 
                    $password = md5($_POST['password']);
                    $address = $_POST['address'];
                    $email = $_POST['email']; 
                    $mobile = $_POST['mobile'];
                    $id = $_POST['id'];
						
						//update query
					$stmnt = "UPDATE pet_owners SET name = '$name',username= '$username',password= '$password',address='$address',email='$email',mob_no='$mobile' WHERE id = '$id';";
						if(mysqli_query($conn ,$stmt)){
						echo "data insertion succeeded";
							//update the petowner data in response 
							$response['error'] = false; 
							$response['message'] = 'updated profile successfully'; 
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

