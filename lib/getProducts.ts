import Product from "@/app/interfaces/productInt";
import data from "@/_data/kniyot.json";

export default function getProducts(): Product[]{
  // data est un tableau de 4 objets
  // index 0 = header, index 1 = database, index 2 = categories, index 3 = produits
  const productTable = data[3];
//on verifie si on est bien dans la bonne table
  if (productTable.name === "produits") {
    try {
      return productTable.data as Product[]; //type casting so i can match the return type
    }
    catch (error) {
      console.error(error);
      return [];
    } //le try catch ici est inutile cuz its just a typecasting but im keeping it anyways
  }
  else {
    console.error("the table index is wrong ");
    return []; //return dans toute les possibilites so it matches the return type.
  }
}
