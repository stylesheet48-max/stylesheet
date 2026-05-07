document.addEventListener('contextmenu',e=>e.preventDefault());
document.addEventListener('selectstart',e=>e.preventDefault());
document.addEventListener('keydown',e=>{if((e.ctrlKey&&['u','U','+','-'].includes(e.key))||(e.ctrlKey&&e.shiftKey&&['I','i','J','j','C','c'].includes(e.key))){e.preventDefault();}});
document.addEventListener('wheel',e=>{if(e.ctrlKey)e.preventDefault();},{passive:false});
