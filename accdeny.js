function updateStatus(loanId, action) {
    const statusCell = document.getElementById(`status_${loanId}`);
    const row = statusCell.closest('tr');  
    
    if (statusCell.textContent === 'Pending') {
        // If the action is ACCEPTED
        if (action === 'accept') {
            statusCell.textContent = 'Accepted';  // Change status
            statusCell.style.backgroundColor = '#28a745';  // Set green background
            statusCell.style.color = 'white';  // Change text color to white
            row.setAttribute('data-status', 'accepted');  // Update row status
        }
        // If the action is DENIED
        else if (action === 'deny') {
            statusCell.textContent = 'Denied';  // Change status
            statusCell.style.backgroundColor = '#dc3545';  // Set red background
            statusCell.style.color = 'white';  // Change text color to white
            row.setAttribute('data-status', 'denied');  // Update row status
        }
    } else {
        alert('This loan has already been processed.');
    }
}

function filterLoans() {
    const filterValue = document.getElementById('loanStatusFilter').value;
    const rows = document.querySelectorAll('.loan-row');

    rows.forEach(row => {
        const status = row.getAttribute('data-status');
        
        if (filterValue === 'all') {
            row.style.display = '';  // Show all rows
        } else if (status === filterValue) {
            row.style.display = '';  // Show the row if it matches the filter
        } else {
            row.style.display = 'none';  // Hide the row if it doesn't match
        }
    });
}

window.setTimeout(() => {
    const loanList = [
        {
            id: "001", 
            name: "Justine Briones",
            birthdate: "1990-01-01",
            email: "JustineBriones18@gmail.com",
            purpose: "Home Renovation",
            loanAmount: "$5000",
            status: "Pending"
        },
        {
            id: "002",
            name: "Joshua Umali",
            birthdate: "1985-05-15",
            email: "joshuaumali02@gmail.com",
            purpose: "Business Expansion",
            loanAmount: "$2000",
            status: "Pending"
        }
    ];
    const table = document.getElementById("table-body");
    loanList.forEach(l => {
        const row = document.createElement("tr");
        row.setAttribute("class", "loan-row");

        const idCell = document.createElement("td");
        const nameCell = document.createElement("td");
        const birthdateCell = document.createElement("td");
        const emailCell = document.createElement("td");
        const purposeCell = document.createElement("td");
        const loanAmountCell = document.createElement("td");
        const statusCell = document.createElement("td");
        const actionCell = document.createElement("td");

        
        idCell.innerHTML = `<a href="loan.html">${l.id}</a>`;
        nameCell.textContent = l.name;
        birthdateCell.textContent = l.birthdate;
        emailCell.textContent = l.email;
        purposeCell.textContent = l.purpose;
        loanAmountCell.textContent = l.loanAmount;
        statusCell.textContent = l.status;

    
        const acceptBtn = document.createElement("button");
        const denyBtn = document.createElement("button");

        acceptBtn.setAttribute("class", "accept-btn");
        denyBtn.setAttribute("class", "deny-btn");
        acceptBtn.innerHTML = "Accept";
        denyBtn.innerHTML = "Deny";

        actionCell.appendChild(acceptBtn);
        actionCell.appendChild(denyBtn);


        row.appendChild(idCell);
        row.appendChild(nameCell);
        row.appendChild(birthdateCell);
        row.appendChild(emailCell);
        row.appendChild(purposeCell);
        row.appendChild(loanAmountCell);
        row.appendChild(statusCell);
        row.appendChild(actionCell);

    
        table.appendChild(row);
    });
}, 1000);
