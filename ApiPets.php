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

        //for view pets...................................................................................
        case 'view':
        $id = $_GET['pet_owner_id'];

        //query to get data
        $query = mysqli_query($conn,"SELECT * FROM pets WHERE pet_owner_id='".$_GET['pet_owner_id']."'");

        //insert in ti array
        if($query){
            while($row=mysqli_fetch_array($query)){
                $flag[]=$row;
            }
        //encode it
        print(json_encode($flag));
        }

        
                
        break;

        //add new pet..........................................................................................
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
                    
                }
                else{
                    echo "Data insertion error".mysqli_error($conn);
                }	
                 
        
        break; 

        //send appointment....................................................................................
        case 'appointment':
        
            //getting the values 
            $time = $_POST['time'];
            $date = $_POST['date']; 
            $address = $_POST['address'];
            $type = $_POST['type']; 
            $desc = $_POST['desc'];
            $pet_owner_id = $_POST['pet_owner_id'];
            
                
                //insert query to add appointment details
                $stmt = "INSERT INTO appointments(time,date,address,type,description,pet_owner_id) VALUES('$time','$date','$address','$type','$desc','$pet_owner_id')";											//$stmt->bind_param($id,$name,$username,$password,$address,$mobile,$email,$imageURL);
                
                if(mysqli_query($conn ,$stmt)){
                    echo "data insertion succeeded";
                   
                }
                else{
                    echo "Data insertion error".mysqli_error($conn);
                }	
               
        
            break; 

        //find all pets of a client..............................................................................

        case 'find':
        
        //qery to get pets
        $query = mysqli_query($conn,"SELECT age,weight,species,special_note,colour FROM pets WHERE pet_owner_id='".$_GET['pet_owner_id']."' AND name='".$_GET['name']."' ");


        if($query){

            while($row=mysqli_fetch_array($query)){
            
                $flag[]=$row;
            }
            print(json_encode($flag));
        }

        break;


        //update petdetails......................................................................................
        case 'update':

            $name =  $_POST['name'];
            $age =  $_POST['age'];
            $weight = $_POST['weight'];

						//query to update  details
						$stmt = "UPDATE pets SET age='$age',weight='$weight' WHERE pet_owner_id='".$_POST['pet_owner_id']."' AND name='".$_POST['name']."' ";

						if(mysqli_query($conn ,$stmt)){
							echo "data updated ";
								 
							}
							else{
								echo "Somethiing error!".mysqli_error($conn);
                            }
                           	
        break;

        //remove a pet..........................................................................................
        case 'delete':

            //qery to delete a pet
             $query = mysqli_query($conn,"DELETE FROM pets WHERE pet_owner_id='".$_POST['pet_owner_id']."' AND name='".$_POST['name']."' ");
            if($query){
                echo "pet removed!";
            }
            else{
                echo "Somethiing error!";
            }

        break;

         //view treatments....................................................................................
        case 'treatments':

        //query to get treatments
        $query = mysqli_query($conn,"SELECT medicines,description,date FROM treatment WHERE pet_owner_id='".$_GET['pet_owner_id']."' AND pet_name='".$_GET['pet_name']."' ");
       
        if($query){
            while($row=mysqli_fetch_array($query)){
                $flag[]=$row;
            }
            print(json_encode($flag));
        }

        break;

        }
    }