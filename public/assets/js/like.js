// on indexe tous les bouttons de classes "like-btn"
let allBtnLike = document.querySelectorAll('.like-btn');

for (let index = 0; index < allBtnLike.length; index++) {
    const btn = allBtnLike[index];
    
    btn.addEventListener('click', e=>{
        if (btn.style.color =="red") {
            btn.style.color = "white"
        }else{
            btn.style.color = "red"
        }
        // requête ajax; e.target.id=id du coeur
        fetch('/like/'+e.target.id)
    })
}

let allBtnDelete = document.querySelectorAll('.delete-btn');

for (let index = 0; index < allBtnDelete.length; index++) {
    const btn = allBtnDelete[index];
    
    btn.addEventListener('click', e=>{   
        // requête ajax; e.target.id=id du coeur
        fetch('/delete/'+e.target.id)
        window.location.reload();
    })
}