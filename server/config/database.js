import { Sequelize } from "sequelize";
import mysql from "mysql2";

export default new Sequelize(
    process.env.DB_DATABASE,
    process.env.DB_USER,
    process.env.DB_PASSWORD,
    {
        host: process.env.DB_HOST,
        dialect: "mysql",
        dialectModule: mysql,
        logging: false,
    }
);
