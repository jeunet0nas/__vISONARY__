export const formatPrice = (price) => {
  const num = Number(price);
  if (isNaN(num)) return price;
  return new Intl.NumberFormat("vi-VN", {
    style: "currency",
    currency: "VND",
  }).format(num);
};
