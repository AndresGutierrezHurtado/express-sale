export const useConvertImage = async (image) => {
    const reader = new FileReader();
    reader.readAsDataURL(image);
    return new Promise((resolve) => reader.onload = () => resolve(reader.result));
};
