const express = require('express');
const cors = require('cors');
const axios = require('axios');

const app = express();
app.use(cors());

app.post('/registro', async (req, res) => {
    try {
        const response = await axios.post('https://furrlist-production.up.railway.app/#registerPage', req.body);
        res.json(response.data);
    } catch (error) {
        res.status(500).json({ error: 'Error al procesar la solicitud' });
    }
});

const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
    console.log(`Servidor intermedio escuchando en el puerto ${PORT}`);
});
