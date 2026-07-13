import Image from "next/image";
import Product from "../interfaces/productInt";
import Link from "next/link";
export default function BigCarrousel({ product } : {product:Product}): React.ReactElement { //<---- destruct React components must starts with capital cases or itll not be recognized
  return (
    <div className=" flex justify-center  m-4">{/*Big wrapper */}
      <div className="mr-70 flex text-center flex-col">{/*-----------------------------------------------LEFT PART txt */}
        <span className="bg-gray-200  text-secondaryg rounded-2xl font-bold p-2 w-max text-center block my-13 ml-60 ">What's New ?</span>
        <h1 className="text-5xl font-bold">Explore our <span className="text-secondaryg relative after:absolute after:w-25 after:h-2 after:bg-lime-100 after:content-[''] after:bottom-0 after:left-0">
          New </span>
           Products
        </h1>
        <p className="mt-10">Connect directly with wholesalers and increase the visibility of your products. <br />
        Publish on our platform and reach new markets without intermediaries.
        </p>
        <Link href="#" className="bg-secondaryg text-white w-fit pt-0 py-3 font-bold rounded-lg px-3 ml-55 my-9">
          View offer <span className="text-3xl">→</span>
        </Link>
      </div>
      <div>     {/*-----------------------------------------------RIGHT PART */}
        <Image src={product.image} alt={product.nom} height={100} width={390} className="relative mt-30" />
        <p className="font-bold p-4 py-8 rounded-full bg-primaryg absolute  text-white right-[10em] top-[24em] shadow-2xl">‎ ‎ ‎ ‎ ‎ ‎ ‎ ‎50%<br/>DISCOUNT</p>
      </div>
    </div>
  )
}

//------------------------IMPORTANT NOTES--------------------------------------------------------------------------------------------
//ntm: on a le tableau Product[] qui contient les objets like Product[1].name or whatever floats the boat (-_-)
// props par defaut est un objet peut importe ce que on y passe donc je doit destructurer un objet avant de l'y passer ALWAYS DESTRUCT A PROP
