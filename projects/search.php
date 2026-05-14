<?php require_once("../middleware/auth.php"); ?>
<?php

if (!isset($_SESSION['user'])) {
    header("Location: ../public/login.php");
    exit();
}

require_once(__DIR__ . "/../database/db.php");

$search = $_GET['search'] ?? "";

if(strtolower($_SESSION['role']) == "admin"){
    if(isset($_GET['approve'])){
        $id = intval($_GET['approve']);
        mysqli_query($conn,"UPDATE projects SET status='approved' WHERE id=$id");
    }

    if(isset($_GET['reject'])){
        $id = intval($_GET['reject']);
        mysqli_query($conn,"UPDATE projects SET status='rejected' WHERE id=$id");
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Projects</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:Poppins;}

body{
    background: linear-gradient(135deg,#4f46e5,#9333ea);
    color:white;
}

.container{
    max-width:1200px;
    margin:auto;
    padding:20px;
}


.top-bar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.back-btn{
    background:rgba(255,255,255,0.2);
    padding:8px 12px;
    border-radius:8px;
    color:white;
    text-decoration:none;
}


.search-box{
    display:flex;
    gap:10px;
    margin-bottom:20px;
}

.search-box input{
    flex:1;
    padding:12px;
    border:none;
    border-radius:8px;
}

.search-box button{
    padding:12px 20px;
    background:#2563eb;
    border:none;
    border-radius:8px;
    color:white;
}


.table-wrapper{
    overflow-x:auto;
}

table{
    width:100%;
    border-collapse:collapse;
    background:rgba(255,255,255,0.1);
    border-radius:10px;
    overflow:hidden;
}

th{
    background:rgba(0,0,0,0.5);
    padding:14px;
}

td{
    padding:14px;
    text-align:center;
    border-bottom:1px solid rgba(255,255,255,0.1);
}

tr:hover{
    background:rgba(255,255,255,0.05);
}

td:nth-child(2),
th:nth-child(2){
    white-space: nowrap;
    min-width: 120px;
}

.abstract{
    max-width:180px;
    overflow:hidden;
    text-overflow:ellipsis;
    white-space:nowrap;
}


.media{
    width:120px;
}

audio.media{height:35px;}


.pending{color:yellow;}
.approved{color:#4ade80;}
.rejected{color:#f87171;}


.action{
    display:flex;
    justify-content:center;
    gap:6px;
}

.action a{
    display:flex;
    align-items:center;
    justify-content:center;
    width:32px;
    height:32px;
    border-radius:6px;
    color:white;
    text-decoration:none;
}

.approve{background:#22c55e;}
.reject{background:#facc15;color:black;}
.delete{background:#ef4444;}


@media (max-width:768px){

.top-bar{
    flex-direction:column;
    gap:10px;
}

.search-box{
    flex-direction:column;
}

.search-box input,
.search-box button{
    width:100%;
}

table{
    min-width:800px;
    font-size:12px;
}

.abstract{
    max-width:180px;
}

}

.view-btn{
    padding:5px 10px;
    background:#2563eb;
    color:white;
    border:none;
    border-radius:5px;
    cursor:pointer;
}

.modal{
    display:none;
    position:fixed;
    left:0;
    top:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.6);
    z-index:9999;
}

.modal-content{
    background:white;
    color:black;
    width:60%;
    max-width:600px;
    margin:10% auto;
    padding:20px;
    border-radius:10px;
    position:relative;
    max-height:70vh;
    overflow-y:auto;
}

.close{
    position:absolute;
    top:10px;
    right:15px;
    font-size:28px;
    cursor:pointer;
}

</style>

</head>

<body>

<div class="container">

<div class="top-bar">
<h2>📊 Projects</h2>

<?php if(strtolower($_SESSION['role']) == "admin"){ ?>
<a href="../dashboard/admin_dashboard.php" class="back-btn">Home</a>
<?php } else { ?>
<a href="../dashboard/user_dashboard.php" class="back-btn">Home</a>
<?php } ?>
</div>

<form method="GET" class="search-box">
<input type="text" name="search" placeholder="Search projects..."
value="<?php echo htmlspecialchars($search); ?>">
<button>Search</button>
</form>

<div class="table-wrapper">
<table>

<tr>
<th>Name</th>
<th>Roll</th>
<th>Department</th>
<th>Batch</th>
<th>Project</th>
<th>Abstract</th>
<th>Audio</th>
<th>Video</th>
<th>Status</th>

<?php if(strtolower($_SESSION['role']) == "admin"){ ?>
<th>Action</th>
<?php } ?>
</tr>

<?php

$query = "SELECT * FROM projects WHERE 1=1";


if(strtolower($_SESSION['role']) != "admin"){
    $query .= " AND status='approved'";
}


if($search != ""){
    $query .= " AND (
        student_name LIKE '%$search%' OR
        roll_no LIKE '%$search%' OR
        department LIKE '%$search%' OR
        project_title LIKE '%$search%'
    )";
}

$query .= " ORDER BY batch_year ASC, CAST(roll_no AS UNSIGNED) ASC";

$result = mysqli_query($conn,$query);

if(mysqli_num_rows($result)>0){

while($row=mysqli_fetch_assoc($result)){
?>

<tr>
<td><?php echo htmlspecialchars($row['student_name']); ?></td>
<td><?php echo htmlspecialchars($row['roll_no']); ?></td>
<td><?php echo htmlspecialchars($row['department']); ?></td>
<td><?php echo $row['batch_year']; ?></td>
<td><?php echo htmlspecialchars($row['project_title']); ?></td>

<td class="abstract">
<?php if(!empty($row['abstract'])) { ?>
    <?php echo htmlspecialchars(substr($row['abstract'],0,30))."..."; ?>
    <br>
    <button 
        class="view-btn"
        data-abstract="<?php echo htmlspecialchars($row['abstract']); ?>"
        onclick="showModal(this)">
        View
    </button>
<?php } else { ?>
    N/A
<?php } ?>
</td>

<td>
<?php if(!empty($row['audio'])){ ?>
<audio controls class="media">
<source src="../uploads/audio/<?php echo $row['audio']; ?>" type="audio/mpeg">
</audio>
<?php } else echo "—"; ?>
</td>

<td>
<?php if(!empty($row['video'])){ ?>
<video controls class="media" playsinline>
<source src="../uploads/videos/<?php echo $row['video']; ?>" type="video/mp4">
</video>
<?php } else echo "—"; ?>
</td>

<td class="<?php echo $row['status']; ?>">
<?php echo $row['status']; ?>
</td>

<?php if(strtolower($_SESSION['role']) == "admin"){ ?>
<td class="action">

<a href="?approve=<?php echo $row['id']; ?>" class="approve">✔</a>

<a href="?reject=<?php echo $row['id']; ?>" class="reject">✖</a>

<a href="delete_project.php?id=<?php echo $row['id']; ?>" 
class="delete"
onclick="return confirm('Delete project?')">🗑</a>

</td>
<?php } ?>

</tr>

<?php } 

}else{
echo "<tr><td colspan='9'>❌ No Data Found</td></tr>";
}
?>

</table>
</div>

</div>
<div id="abstractModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h3>Project Abstract</h3>
        <p id="abstractText"></p>
    </div>
</div>

<script>
function showModal(btn){
    let text = btn.getAttribute("data-abstract");
    document.getElementById("abstractText").innerHTML = text.replace(/\n/g, "<br>");
    document.getElementById("abstractModal").style.display = "block";
}

function closeModal(){
    document.getElementById("abstractModal").style.display = "none";
}

window.onclick = function(event){
    let modal = document.getElementById("abstractModal");
    if(event.target == modal){
        modal.style.display = "none";
    }
}
</script>
</body>
</html>