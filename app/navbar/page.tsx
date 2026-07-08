import Image from "next/image";

export default function Navbar() {
  return (
    <div className="w-full h-12 bg-primaryg flex  text-white text-[12px] ">
      {/*le big Flex qui enveloppe toute la Navbar */}
      <div className="my-4 inline">
        {/*Div des elts a gauche*/}
        <p className="pl-1 ml-67.5 inline  hover:text-gray-200">
          <Image
            src={"phone.svg"}
            width={18}
            height={20}
            alt="phone"
            className="inline fill-white"
          />
          <span>Customer Support: +xx xxx xx</span>
        </p>
        <p className="pl-1  ml-7 inline  hover:text-gray-200">
          <Image
            src={"mail.svg"}
            width={18}
            height={20}
            alt="phone"
            className="inline fill-white"
          />
          <span>Nier_Automata@proton.me</span>
        </p>
      </div>
      <div className="my-4 ml-90 inline">
        {/*Div des elts a droite*/}
        <p className="pl-1  inline  hover:text-gray-200">
          <Image
            src={"truck.svg"}
            width={20}
            height={20}
            alt="phone"
            className="inline fill-white"
          />
          <span className="px-2">Track order</span>
        </p>
        <p className="pl-1 ml-4 inline  hover:text-gray-200">
          <Image
            src={"translate.svg"}
            width={15}
            height={20}
            alt="phone"
            className="inline fill-white"
          />
          <span className="px-2">English</span>
          {/*Sera peut etre modifie en option pour switch de langues*/}
        </p>
        <p className="pl-1 ml-4 inline  hover:text-gray-200">
          <Image
            src={"dollar.svg"}
            width={15}
            height={20}
            alt="phone"
            className="inline fill-white"
          />
          <span className="">XOF</span>
          {/*Sera peut etre modifie en option pour switch currency*/}
        </p>
      </div>
    </div>
  );
}
