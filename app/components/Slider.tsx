"use client";
import BigCarrousel from "./bigCarrousel";
import getProducts from "@/lib/getProducts";
import Product from "../interfaces/productInt";
import { useState } from "react";

export default function Slider(): React.ReactElement {
  const [current, setCurrent] = useState(0);
  const Products = getProducts();
  const slides = [Products[2], Products[20], Products[19]];
  const product: Product = Products[current];
  function next() {
    const nextSlide:number = (current + 1) % 3; //le rest de la division par 3 ne depassera pas 3 et reviendra a 0
    setCurrent(nextSlide);
  }
  function prev()  {
    const prevSlide: number = (current - 1 + 3) % 3; //cuz 4%3 = 1
    setCurrent(prevSlide);
  }
    return (
      <div className="w-full">
        <div className=" ">
          <BigCarrousel product={slides[current]} />
        </div>
        <div className="flex justify-center ">
          <button onClick={prev} className="rounded-full px-3.5 py-2 shadow-5xl shadow-md m-5 hover:text-white hover:bg-secondaryg transition-all duration-100 cursor-pointer">ᐸ</button>
          <button onClick={next} className="rounded-full px-3.5 py-2 shadow-5xl shadow-md m-5 hover:text-white hover:bg-secondaryg transition-all duration-100 cursor-pointer">ᐳ</button>
        </div>
      </div>
    )
  }
