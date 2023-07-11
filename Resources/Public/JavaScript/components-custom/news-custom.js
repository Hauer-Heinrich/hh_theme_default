(function(){
  let newsContainerHighest = 0
  document.querySelectorAll(".news-img-wrap + .ce-textpic").forEach((el) => {
    if(io.heightContent(el) > newsContainerHighest){
      newsContainerHighest = io.heightContent(el)
    }
  })

  document.querySelectorAll(".news-img-wrap + .ce-textpic").forEach((el) => {
    el.style.height = newsContainerHighest + "px"
  })
})();

