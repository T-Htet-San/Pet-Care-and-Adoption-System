function loadMore(){

    let container = document.getElementById("petList")
    
    let card = `
    <div class="pet-card">
    
    <div class="row align-items-center">
    
    <div class="col-md-2">
    <img src="https://via.placeholder.com/150">
    </div>
    
    <div class="col-md-3">
    <h5>New Pet</h5>
    </div>
    
    <div class="col-md-5">
    <p>This is another pet added dynamically using JavaScript.</p>
    </div>
    
    <div class="col-md-2 text-end">
    <button class="btn btn-sm btn-primary">More</button>
    </div>
    
    </div>
    
    </div>
    `
    
    container.innerHTML += card
    
    }

    function showInfo(element, text) {
        let container = element.closest(".vet-info");
        let paragraph = container.querySelector(".info-text");
    
        paragraph.innerText = text;
    }