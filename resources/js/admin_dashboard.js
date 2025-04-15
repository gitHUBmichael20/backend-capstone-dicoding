// resources/js/admin_dashboard.js
import Swal from 'sweetalert2';

// Fetch Products
async function fetchProducts() {
  try {
      const response = await axios.get('/api/admin/produk', {
          headers: {
              'Authorization': `Bearer ${document.querySelector('meta[name="api-token"]').getAttribute('content')}`
          }
      });
      const products = response.data;
      const tableBody = document.getElementById('product-table');
      tableBody.innerHTML = '';

      products.forEach(product => {
          const row = document.createElement('tr');
          row.innerHTML = `
              <td class="p-3">${product.nama_produk}</td>
              <td class="p-3">${product.kategori}</td>
              <td class="p-3">${product.stok}</td>
              <td class="p-3">Rp${product.biaya_sewa.toLocaleString('id-ID')}</td>
              <td class="p-3">
                  <img src="${product.gambar_produk ? '/storage/produk/' + product.gambar_produk : '/storage/produk/no_image.png'}" alt="${product.nama_produk}" class="w-10 h-10 object-cover mr-2">
                  <button onclick="editProduct(${product.produk_id})" class="text-blue-600 hover:underline mr-2">Edit</button>
                  <button onclick="deleteProduct(${product.produk_id})" class="text-red-600 hover:underline">Delete</button>
              </td>
          `;
          tableBody.appendChild(row);
      });
  } catch (error) {
      console.error('Error fetching products:', error);
      Swal.fire('Error', 'Failed to load products.', 'error');
  }
}

// Fetch Users
async function fetchUsers() {
    try {
        const response = await axios.get('/api/admin/pengguna', {
            headers: {
                'Authorization': `Bearer ${document.querySelector('meta[name="api-token"]').getAttribute('content')}`
            }
        });
        const users = response.data;
        const tableBody = document.getElementById('user-table');
        tableBody.innerHTML = '';

        users.forEach(user => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="p-3">${user.nama_pengguna}</td>
                <td class="p-3">${user.email}</td>
                <td class="p-3">${user.nomor_telepon || '-'}</td>
                <td class="p-3">
                    <button onclick="editUser(${user.pengguna_id})" class="text-blue-600 hover:underline mr-2">Edit</button>
                    <button onclick="deleteUser(${user.pengguna_id})" class="text-red-600 hover:underline">Delete</button>
                </td>
            `;
            tableBody.appendChild(row);
        });
    } catch (error) {
        console.error('Error fetching users:', error);
        Swal.fire('Error', 'Failed to load users.', 'error');
    }
}

// Show/Hide Product Form
function showProductForm(mode, product = null) {
    const form = document.getElementById('product-form');
    const formTitle = document.getElementById('product-form-title');
    form.classList.remove('hidden');

    if (mode === 'create') {
        formTitle.textContent = 'Add Product';
        document.getElementById('product-crud-form').reset();
        document.getElementById('product-id').value = '';
    } else {
        formTitle.textContent = 'Edit Product';
        document.getElementById('product-id').value = product.produk_id;
        document.getElementById('nama_produk').value = product.nama_produk;
        document.getElementById('deskripsi').value = product.deskripsi;
        document.getElementById('stok').value = product.stok;
        document.getElementById('biaya_sewa').value = product.biaya_sewa;
        document.getElementById('kategori').value = product.kategori;
        document.getElementById('gambar_produk').required = false;
    }
}

function hideProductForm() {
    document.getElementById('product-form').classList.add('hidden');
}

// Show/Hide User Form
function showUserForm(mode, user = null) {
    const form = document.getElementById('user-form');
    const formTitle = document.getElementById('user-form-title');
    form.classList.remove('hidden');

    if (mode === 'create') {
        formTitle.textContent = 'Add User';
        document.getElementById('user-crud-form').reset();
        document.getElementById('user-id').value = '';
        document.getElementById('password').required = true;
    } else {
        formTitle.textContent = 'Edit User';
        document.getElementById('user-id').value = user.pengguna_id;
        document.getElementById('nama_pengguna').value = user.nama_pengguna;
        document.getElementById('email').value = user.email;
        document.getElementById('nomor_telepon').value = user.nomor_telepon || '';
        document.getElementById('alamat').value = user.alamat || '';
        document.getElementById('password').required = false;
    }
}

function hideUserForm() {
    document.getElementById('user-form').classList.add('hidden');
}

// Handle Product Form Submission
document.getElementById('product-crud-form').addEventListener('submit', async (e) => {
  e.preventDefault();
  const id = document.getElementById('product-id').value;
  const formData = new FormData();
  formData.append('nama_produk', document.getElementById('nama_produk').value);
  formData.append('deskripsi', document.getElementById('deskripsi').value);
  formData.append('stok', parseInt(document.getElementById('stok').value));
  formData.append('biaya_sewa', parseInt(document.getElementById('biaya_sewa').value));
  formData.append('kategori', document.getElementById('kategori').value);
  const image = document.getElementById('gambar_produk').files[0];
  if (image) formData.append('gambar_produk', image);
  if (id) formData.append('_method', 'PUT');

  try {
      const url = id ? `/api/admin/produk/${id}` : '/api/admin/produk'; // Perbaiki URL
      const response = await axios.post(url, formData, {
          headers: {
              'Authorization': `Bearer ${document.querySelector('meta[name="api-token"]').getAttribute('content')}`,
              'Content-Type': 'multipart/form-data'
          }
      });
      Swal.fire('Success', id ? 'Product updated successfully!' : 'Product created successfully!', 'success');
      hideProductForm();
      fetchProducts();
  } catch (error) {
      console.error('Error saving product:', error.response ? error.response.data : error.message);
      Swal.fire('Error', 'Failed to save product: ' + (error.response ? error.response.data.message : error.message), 'error');
  }
});

// Handle User Form Submission
document.getElementById('user-crud-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    const id = document.getElementById('user-id').value;
    const data = {
        nama_pengguna: document.getElementById('nama_pengguna').value,
        email: document.getElementById('email').value,
        nomor_telepon: document.getElementById('nomor_telepon').value,
        alamat: document.getElementById('alamat').value,
    };
    if (document.getElementById('password').value) {
        data.password = document.getElementById('password').value;
    }

    try {
        const url = id ? `/api/pengguna/${id}` : '/api/pengguna';
        const method = id ? 'PUT' : 'POST';
        const response = await axios({
            method,
            url,
            data,
            headers: {
                'Authorization': `Bearer ${document.querySelector('meta[name="api-token"]').getAttribute('content')}`,
                'Content-Type': 'application/json'
            }
        });
        Swal.fire('Success', id ? 'User updated successfully!' : 'User created successfully!', 'success');
        hideUserForm();
        fetchUsers();
    } catch (error) {
        console.error('Error saving user:', error);
        Swal.fire('Error', 'Failed to save user.', 'error');
    }
});

// Edit Product
async function editProduct(id) {
  try {
      const response = await axios.get(`/api/admin/produk/${id}`, { // Perbaiki URL
          headers: {
              'Authorization': `Bearer ${document.querySelector('meta[name="api-token"]').getAttribute('content')}`
          }
      });
      showProductForm('edit', response.data);
  } catch (error) {
      console.error('Error fetching product:', error);
      Swal.fire('Error', 'Failed to load product data.', 'error');
  }
}

// Edit User
async function editUser(id) {
    try {
        const response = await axios.get(`/api/pengguna/${id}`, {
            headers: {
                'Authorization': `Bearer ${document.querySelector('meta[name="api-token"]').getAttribute('content')}`
            }
        });
        showUserForm('edit', response.data);
    } catch (error) {
        console.error('Error fetching user:', error);
        Swal.fire('Error', 'Failed to load user data.', 'error');
    }
}

// Delete Product
async function deleteProduct(id) {
  Swal.fire({
      title: 'Are you sure?',
      text: 'This product will be deleted permanently!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!',
      cancelButtonText: 'Cancel'
  }).then(async (result) => {
      if (result.isConfirmed) {
          try {
              await axios.delete(`/api/admin/produk/${id}`, { // Perbaiki URL
                  headers: {
                      'Authorization': `Bearer ${document.querySelector('meta[name="api-token"]').getAttribute('content')}`
                  }
              });
              Swal.fire('Deleted', 'Product has been deleted.', 'success');
              fetchProducts();
          } catch (error) {
              console.error('Error deleting product:', error);
              Swal.fire('Error', 'Failed to delete product.', 'error');
          }
      }
  });
}

// Delete User
async function deleteUser(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'This user will be deleted permanently!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then(async (result) => {
        if (result.isConfirmed) {
            try {
                await axios.delete(`/api/pengguna/${id}`, {
                    headers: {
                        'Authorization': `Bearer ${document.querySelector('meta[name="api-token"]').getAttribute('content')}`
                    }
                });
                Swal.fire('Deleted', 'User has been deleted.', 'success');
                fetchUsers();
            } catch (error) {
                console.error('Error deleting user:', error);
                Swal.fire('Error', 'Failed to delete user.', 'error');
            }
        }
    });
}

window.fetchProducts = fetchProducts;
window.fetchUsers = fetchUsers;
window.showProductForm = showProductForm;
window.hideProductForm = hideProductForm;
window.showUserForm = showUserForm;
window.hideUserForm = hideUserForm;
window.editProduct = editProduct;
window.editUser = editUser;
window.deleteProduct = deleteProduct;
window.deleteUser = deleteUser;