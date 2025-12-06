let userLocation = null;
let items = [];

document.getElementById("loc_btn").onclick = () => {
    if (!navigator.geolocation) {
        alert("Geolocation not supported.");
        return;
    }
    navigator.geolocation.getCurrentPosition(pos => {
        userLocation = {
            lat: pos.coords.latitude,
            lon: pos.coords.longitude
        };
        alert("Location acquired!");
    });
};

document.getElementById("search_btn").onclick = async () => {
    const res = await fetch("/items");
    items = await res.json();
    displayResults(items);
};

function displayResults(list) {
    const results = document.getElementById("results");
    results.innerHTML = "";

    list.forEach(item => {
        const div = document.createElement("div");
        div.className = "card";

        div.innerHTML = `
            <h3>${item.item} — ${item.chain}</h3>
            <p><b>Calories:</b> ${item.calories}</p>
            <p><b>Protein:</b> ${item.protein}g</p>
            <p><b>Price:</b> $${item.price.toFixed(2)}</p>
        `;

        results.appendChild(div);
    });
}

// SORTING
document.getElementById("sortSelect").onchange = (e) => {
    if (!items.length) return;

    let sorted = [...items];

    if (e.target.value === "calories") {
        sorted.sort((a, b) => a.calories - b.calories);
    } else if (e.target.value === "protein") {
        sorted.sort((a, b) => b.protein - a.protein);
    } else if (e.target.value === "price") {
        sorted.sort((a, b) => a.price - b.price);
    }

    displayResults(sorted);
};

// FILTER BY CHAIN
document.getElementById("chainFilter").onchange = (e) => {
    if (!items.length) return;

    const chain = e.target.value;
    if (!chain) {
        displayResults(items);
    } else {
        const filtered = items.filter(i => i.chain === chain);
        displayResults(filtered);
    }
};