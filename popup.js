var summaryBot= {};
document.querySelector('.update').addEventListener("click",()=>{
    var email =document.querySelector('.betaEmail').value;
    console.log(email);
})

if(email=""){
    document.querySelector('.first').style.display='none';
    document.querySelector('.success').style.display='block';

    summaryBot["email"]= email;

    chrome.storage.sync.set({
        summaryBot
    },function(){
        console.log(summaryBot);

    })

}
