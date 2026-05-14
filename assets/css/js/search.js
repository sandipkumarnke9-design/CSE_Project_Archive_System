function searchProjects(){

let keyword=document.getElementById("search").value;

fetch("api/projects_api.php")

.then(res=>res.json())

.then(data=>{

let html="";

data.forEach(p=>{

if(p.student_name.includes(keyword)){

html+=`<tr>
<td>${p.student_name}</td>
<td>${p.roll_no}</td>
<td>${p.project_title}</td>
</tr>`;

}

});

document.getElementById("results").innerHTML=html;

});

}
