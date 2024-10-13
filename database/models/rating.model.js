const { DataTypes } = require("sequelize");
const conn = require("../config/connection");

const Rating = conn.define(
    "Rating",
    {
        calificacion_id: {
            type: DataTypes.INTEGER,
            primaryKey: true,
            autoIncrement: true,
        },
        calificacion_comentario: {
            type: DataTypes.TEXT,
            allowNull: false,
        },
        calificacion_imagen_url: {
            type: DataTypes.STRING(255),
            allowNull: true,
        },
        calificacion_fecha: {
            type: DataTypes.DATE,
            defaultValue: DataTypes.NOW,
        },
        calificacion: {
            type: DataTypes.INTEGER,
            allowNull: false,
        },
        usuario_id: {
            type: DataTypes.INTEGER,
            allowNull: false,
        },
    },
    {
        tableName: "calificaciones",
        timestamps: false,
    }
);

const ProductsCalifications = conn.define(
    "productsCalifications",
    {
        calificacion_id: {
            type: DataTypes.INTEGER,
        },
        producto_id: {
            type: DataTypes.INTEGER,
        },
    },
    {
        tableName: "calificaciones_productos",
        timestamps: false,
    }
);

const UsersCalifications = conn.define(
    "usersCalifications",
    {
        calificacion_id: {
            type: DataTypes.INTEGER,
        },
        usuario_id: {
            type: DataTypes.INTEGER,
        },
    },
    {
        tableName: "calificaciones_usuarios",
        timestamps: false,
    }
);

module.exports = { Rating, ProductsCalifications, UsersCalifications };
