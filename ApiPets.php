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

        //for view pets
        case 'view':
        $id = $_GET['pet_owner_id'];

        $query = mysqli_query($conn,"SELECT * FROM pets WHERE pet_owner_id='".$_GET['pet_owner_id']."'");

        if($query){
            while($row=mysqli_fetch_array($query)){
                $flag[]=$row;
            }
        print(json_encode($flag));
        }

        
                
        break;

        //add new pet
        case 'add':
        
            //getting the values 
            $age = $_POST['age'];
            $name = $_POST['name']; 
            $weight = $_POST['weight'];
            $species = $_POST['species']; 
            $colour = $_POST['colour'];
            $image = $_POST['image'];
            $id = $_POST['pet_owner_id'];
                
                //insert query to add new pet
                $stmt = "INSERT INTO pets(age,name,weight,species,colour,image,pet_owner_id) VALUES('$age','$name','$weight','$species','$colour','$image','$id')";											//$stmt->bind_param($id,$name,$username,$password,$address,$mobile,$email,$imageURL);
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

        }
    }