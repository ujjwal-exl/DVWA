function show_save_result (data) {
	if (data.result == 'ok') {
		document.getElementById('save_result').innerText = 'Save Successful';
	} else {
		document.getElementById('save_result').innerText = 'Save Failed';
	}
}
	
function submit_change(id) {
	first_name = document.getElementById('first_name_' + id).value
	surname = document.getElementById('surname_' + id).value

	fetch('change_user_details.php', {
		method: 'POST',
		headers: {
			'Accept': 'application/json',
			'Content-Type': 'application/json'
		},
		body: JSON.stringify({ 'id': id, 'first_name': first_name, 'surname': surname })
	}
	)
	.then((response) => response.json())
	.then((data) => show_save_result(data));
}

function populate_form() {
	var xhr= new XMLHttpRequest();
	xhr.open('GET', 'get_user_data.php', true);
	xhr.onreadystatechange= function() {
		if (this.readyState!==4) {
			return;
		}
		if (this.status!==200) {
			return;
		}
		const users = JSON.parse (this.responseText);
		table_body = document.getElementById('user_table').getElementsByTagName('tbody')[0];
		users.forEach(updateTable);

		function updateTable (user) {
			var row = table_body.insertRow(0);
			var cell0 = row.insertCell(-1);
			var uid = Number(user['user_id']);
			cell0.textContent = String(uid);
			var hid = document.createElement('input');
			hid.type = 'hidden';
			hid.id = 'user_id_' + uid;
			hid.name = 'user_id';
			hid.value = String(uid);
			cell0.appendChild(hid);
			var cell1 = row.insertCell(1);
			var fn = document.createElement('input');
			fn.type = 'text';
			fn.id = 'first_name_' + uid;
			fn.name = 'first_name';
			fn.value = user['first_name'];
			cell1.appendChild(fn);
			var cell2 = row.insertCell(2);
			var sn = document.createElement('input');
			sn.type = 'text';
			sn.id = 'surname_' + uid;
			sn.name = 'surname';
			sn.value = user['surname'];
			cell2.appendChild(sn);
			var cell3 = row.insertCell(3);
			var btn = document.createElement('input');
			btn.type = 'button';
			btn.value = 'Update';
			btn.addEventListener('click', function () { submit_change(uid); });
			cell3.appendChild(btn);
		}
	};
	xhr.send();
}
