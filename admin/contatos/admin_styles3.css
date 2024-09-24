/* Importação da fonte Montserrat */
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap');

/* Reseta margens e paddings */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Montserrat', sans-serif;
    background-color: #121212;
    color: #e0e0e0;
}

/* Container principal */
.container {
    max-width: 1200px;
    margin: 20px auto;
    padding: 20px;
}

/* Top bar */
.top-bar {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.top-bar h1 {
    margin: 0;
    color: #e0e0e0;
}

.top-bar-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 10px;
}

.top-bar-buttons button,
.top-bar-buttons .logout-btn {
    padding: 10px 20px;
    border: none;
    background-color: #1e88e5;
    color: #fff;
    font-size: 16px;
    border-radius: 5px;
    cursor: pointer;
    text-decoration: none;
    transition: background 0.3s;
}

.top-bar-buttons button:hover,
.top-bar-buttons .logout-btn:hover {
    background-color: #1565c0;
}

/* Tabela de contatos */
.table-container {
    overflow-x: auto;
}

table {
    border-collapse: collapse;
    width: 100%;
    background-color: #1e1e1e;
    margin-bottom: 40px;
}

table th, table td {
    border: 1px solid #424242;
    padding: 12px;
    text-align: left;
    color: #e0e0e0;
}

table th {
    background-color: #212121;
}

table tr:nth-child(even) {
    background-color: #1a1a1a;
}

/* Link de deletar */
table a.delete-btn {
    color: #e53935;
    text-decoration: none;
}

table a.delete-btn:hover {
    text-decoration: underline;
}

/* Modal */
.modal {
    display: none;
    position: fixed;
    z-index: 100;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow-y: auto;
    background-color: rgba(0,0,0,0.8);
}

.modal.show {
    display: block;
    animation: fadeIn 0.3s;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.modal-content {
    background-color: #1e1e1e;
    margin: 50px auto;
    padding: 20px;
    border: none;
    width: 90%;
    max-width: 600px;
    border-radius: 10px;
    position: relative;
}

.close-btn {
    color: #e0e0e0;
    position: absolute;
    top: 15px;
    right: 20px;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

.close-btn:hover,
.close-btn:focus {
    color: #9e9e9e;
}

/* Formulário de adicionar contato */
.add-contact-form .form-row {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    margin-bottom: 15px;
}

.add-contact-form .input-group {
    flex: 1 1 200px;
    min-width: 200px;
}

.add-contact-form .input-group label {
    display: block;
    color: #e0e0e0;
    font-weight: bold;
    margin-bottom: 5px;
}

.add-contact-form .input-group input[type="text"],
.add-contact-form .input-group input[type="email"],
.add-contact-form .input-group textarea {
    width: 100%;
    padding: 12px;
    border: 1px solid #424242;
    border-radius: 5px;
    background-color: #121212;
    color: #e0e0e0;
    font-size: 16px;
}

.add-contact-form .input-group input::placeholder,
.add-contact-form .input-group textarea::placeholder {
    color: #9e9e9e;
}

.add-contact-form textarea {
    resize: vertical;
    height: 100px;
}

.add-contact-form button[type="submit"] {
    width: 100%;
    padding: 15px;
    border: none;
    background-color: #43a047;
    color: #fff;
    font-size: 18px;
    border-radius: 10px;
    cursor: pointer;
    transition: background 0.3s;
    margin-top: 20px;
}

.add-contact-form button[type="submit"]:hover {
    background-color: #388e3c;
}

/* Removendo estilos relacionados a radio-group */
.add-contact-form .radio-group {
    display: none;
}

/* Estilos para a página de login */
.login-container {
    max-width: 400px;
    margin: 100px auto;
    padding: 20px;
    background-color: #1e1e1e;
    border-radius: 10px;
    text-align: center;
}

.login-container h2 {
    color: #e0e0e0;
    margin-bottom: 20px;
}

.login-form .input-group {
    margin-bottom: 20px;
    text-align: left;
}

.login-form .input-group label {
    display: block;
    color: #e0e0e0;
    font-weight: bold;
    margin-bottom: 5px;
}

.login-form .input-group input[type="text"],
.login-form .input-group input[type="password"] {
    width: 100%;
    padding: 12px;
    border: 1px solid #424242;
    border-radius: 5px;
    background-color: #121212;
    color: #e0e0e0;
    font-size: 16px;
}

.login-form button[type="submit"] {
    width: 100%;
    padding: 15px;
    border: none;
    background-color: #1e88e5;
    color: #fff;
    font-size: 18px;
    border-radius: 10px;
    cursor: pointer;
    transition: background 0.3s;
}

.login-form button[type="submit"]:hover {
    background-color: #1565c0;
}

.error-message {
    color: #e53935;
    margin-bottom: 20px;
}

/* Responsividade */

/* Ajustes para telas menores que 800px */
@media (max-width: 800px) {
    /* Top bar adjustments */
    .top-bar {
        flex-direction: column;
        align-items: flex-start;
    }

    .top-bar-buttons {
        margin-top: 10px;
    }

    /* Formulário de adicionar contato */
    .add-contact-form .form-row {
        flex-direction: column;
    }

    /* Tabela responsiva */
    table th, table td {
        white-space: nowrap;
    }

    /* Ajustar largura da coluna de descrição */
    table th:nth-child(6),
    table td:nth-child(6) {
        width: 300px;
    }

    /* Melhorar a visualização da descrição */
    table td:nth-child(6) {
        white-space: pre-wrap;
    }
}

/* Ajustes para telas menores que 600px */
@media (max-width: 600px) {
    .container {
        margin: 10px;
        padding: 10px;
    }
    .top-bar h1 {
        font-size: 24px;
    }
    .top-bar-buttons button,
    .top-bar-buttons .logout-btn {
        padding: 8px 12px;
        font-size: 14px;
    }
    .add-contact-form .input-group input[type="text"],
    .add-contact-form .input-group input[type="email"],
    .add-contact-form .input-group textarea {
        font-size: 14px;
        padding: 10px;
    }
    .add-contact-form button[type="submit"] {
        font-size: 16px;
        padding: 12px;
    }
    .close-btn {
        font-size: 24px;
        top: 10px;
        right: 15px;
    }

    /* Ajuste na tabela para permitir rolagem horizontal */
    .table-container {
        overflow-x: auto;
    }

    /* Ajuste largura da coluna de descrição */
    table th:nth-child(6),
    table td:nth-child(6) {
        width: 200px;
    }
}
