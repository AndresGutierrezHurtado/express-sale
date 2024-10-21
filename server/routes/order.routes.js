import { Router } from "express";
import OrderController from "../controllers/orderController.js";

const orderRoutes = Router();

orderRoutes.post("/orders", OrderController.createOrder);
orderRoutes.get("/orders/:id", OrderController.getOrder);
orderRoutes.put("/orders/:id", OrderController.updateOrder);

export default orderRoutes;