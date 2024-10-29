import multer from "multer";
import { v2 as cloudinary } from "cloudinary";

// Cloudinary
(async function () {
    cloudinary.config({
        cloud_name: process.env.CLOUDINARY_CLOUD_NAME,
        api_key: process.env.CLOUDINARY_API_KEY,
        api_secret: process.env.CLOUDINARY_API_SECRET,
    });
    const uploadImage = await cloudinary.uploader
        .upload("https://res.cloudinary.com/demo/image/upload/getting-started/shoes.jpg", {
            public_id: "shoes",
        })
        .catch((error) => {
            console.error(error);
        });

    const optimizeUrl = cloudinary.url("shoes", {
        fetch_format: "auto",
        quality: "auto",
    });
})();

const storage = multer.memoryStorage();

export const upload = multer({ storage });

export const uploadFile = async (file, id, type = "image") => {
    try {
        const base64Data = file.replace(/^data:image\/\w+;base64,/, '');
        const buffer = Buffer.from(base64Data, 'base64');

        const result = await cloudinary.uploader.upload_stream(
            {
                public_id: id,
                overwrite: true,
                unique_filename: false,
                resource_type: type == "image" ? "image" : "video",
                format: type == "image" ? "jpg" : "mp4",
                transformation: [
                    { quality: "auto:sensitive", fetch_format: "auto" }
                ]
            },
            (error, result) => {
                if (error) throw new Error(error.message);
                return result;
            }
        );

        buffer.pipe(result);
        return {
            success: true,
            message: "Imagen subida correctamente",
            data: result
        };
    } catch (error) {
        return {
            success: false,
            message: error.message,
            data: null
        };
    }
};

export const deleteFile = (public_id) => {
    cloudinary.uploader.destroy(public_id, (error, result) => {
        if (error) {
            return {
                success: false,
                message: error.message,
                data: null,
            };
        }

        return {
            success: true,
            message: "Imagen eliminada correctamente",
            data: result,
        };
    });
};
