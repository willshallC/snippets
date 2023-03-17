const cards = document.querySelectorAll(".cards");

let cardOne, cardTwo;

function flipCard(e){
    let clickedCard = e.target;
    clickedCard.classList.add("flip");
    cardOne = clickedCard;
}

cards.forEach(card=>{
    card.addEventListener('click', flipCard);
})