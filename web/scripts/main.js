document.addEventListener('DOMContentLoaded', () => {

  fetch("http://localhost:3000/firms/list")
    .then((response) => response.json())
    .then((data) => {
      const container = document.getElementById("firms-container");
      const firms = data.data;

      Object.keys(firms).forEach((firmName) => {
        const firmDiv = document.createElement("div");
        firmDiv.className = "firm";

        const firmTitle = document.createElement("h2");
        firmTitle.textContent = firmName;
        firmDiv.appendChild(firmTitle);

        const hideButton = document.createElement("button");
        hideButton.className = "hide-button";
        hideButton.addEventListener('click', function() {
            if (this.parentElement.lastChild.style.display == 'none') {
                this.parentElement.lastChild.style.display = 'block';
                this.firstChild.src = 'images/minus.svg';
            } else {
                this.parentElement.lastChild.style.display = 'none';
                this.firstChild.src = 'images/plus.svg';
            }   
        });
        buttonImage = document.createElement('img');
        buttonImage.src = "images/plus.svg";
        buttonImage.alt = "hide button";
        hideButton.appendChild(buttonImage);
        firmDiv.appendChild(hideButton);
        
        const contactsList = document.createElement("div");
        contactsList.className = "contact-list";

        const navDiv = document.createElement("div");
        navDiv.className = "firm-nav contact";
        
        const p1 = document.createElement("p");
        p1.textContent = 'Name';
        navDiv.appendChild(p1);
        const p2 = document.createElement("p");
        p2.textContent = 'Surname';
        navDiv.appendChild(p2);
        const p3 = document.createElement("p");
        p3.textContent = 'Email';
        navDiv.appendChild(p3);
        const p4 = document.createElement("p");
        p4.textContent = 'Phone';
        navDiv.appendChild(p4);

        contactsList.append(navDiv);

        firms[firmName].forEach((contact) => {
          const contactDiv = document.createElement("div");
          contactDiv.className = "contact";
            
          
            const img = document.createElement("img");
            img.src = "images/user.svg";
            if (contact["main"]) {
                img.src = "images/star.svg";
            }
            img.alt = "star";
            contactDiv.appendChild(img);


          ["name", "surname", "email", "phone"].forEach((field) => {
            const p = document.createElement("p");
            p.className = field;
            if (contact[field] != "") {
                p.textContent = contact[field];
            } else {
                p.textContent = "-";
            }
            
            contactDiv.appendChild(p);
          });

          contactsList.appendChild(contactDiv);
        });

        firmDiv.append(contactsList);
        container.appendChild(firmDiv);
      });
    })
    .catch((error) => console.error("Error:", error));

});
