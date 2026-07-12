import Image from "next/image";
import Product from "../interfaces/productInt";

export default function BigCarrousel({ product } : {product:Product}): React.ReactElement { //<---- destruct React components must starts with capital cases or itll not be recognized
  return (
    <div className=" flex">{/*Big wrapper */}
      <span className="bg-">What s New</span>
      <Image src={product.image} alt={product.nom} height={100} width={200}/>
    </div>
  )
}

//------------------------IMPORTANT NOTES--------------------------------------------------------------------------------------------
//ntm: on a le tableau Product[] qui contient les objets Product.smtg like Product[1].name or whatever floats the boat (-_-)
// props par defaut est un objet peut importe ce que on y passe donc je doit destructurer un objet avant de l'y passer ALWAYS DESTRUCT A PROP
