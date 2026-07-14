"use client";
import BigCarrousel from "./bigCarrousel";
import getProducts from "@/lib/getProducts";
import Product from "../interfaces/productInt";

export default function Slider(): React.ReactElement {
  const products: Product[] = getProducts();
  const orange: Product = products[2];
  const avocat: Product = products[20];
  const mangue: Product = products[19];
  return (
    <div className="w-full h-fit">
      <div className="flex gap-8 ">
        <span className="flex-3">
          <BigCarrousel product={orange} />
        </span>
        <span className="flex-1">
          <BigCarrousel product={avocat} />
        </span>
        <span className="flex-1">
          <BigCarrousel product={mangue} />
        </span>
      </div>
      <div className="flex justify-center ">
        <button className="rounded-full px-3.5 py-2 shadow-5xl shadow-md m-5 hover:text-white hover:bg-secondaryg transition-all duration-100 cursor-pointer">ᐸ</button>
        <button className="rounded-full px-3.5 py-2 shadow-5xl shadow-md m-5 hover:text-white hover:bg-secondaryg transition-all duration-100 cursor-pointer">ᐳ</button>
      </div>
    </div>
  )
}
