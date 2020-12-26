var summaryBot= {};
document.querySelector('.update').addEventListener("click",()=>{
    var email =document.querySelector('.betaEmail').value;
    console.log(email);
    
    
    if(email!=""){
        document.querySelector('.first').style.display='none';
        document.querySelector('.success').style.display='block';
    
        summaryBot["email"]=email;
    
        chrome.storage.sync.set({
            summaryBot
        }, function() {
            console.log(summaryBot);
        });
    }
    
    var data = new FormData();
    data.append("email", email);
    
    var xhr = new XMLHttpRequest();
    
    xhr.addEventListener("readystatechange", function() {
    if(this.readyState === 4) {
        console.log(this.responseText);
    }
    });
})
