import Image from "next/image";

export default function Home() {
  return (
    <div className="flex p-4 justify-center">
      {/*Big div wrapper */}
      <Image
        src={"/images/gromuse.png"}
        alt="logo"
        height={100}
        width={180}
        className="inline"
      />
      <div className="w-[50%] h-12 bg-amber-200 border border-gray-300">
        {/*searchbar div */}
        <span className="border-r h-full border-gray-900">
          <Image
            src={"pin.svg"}
            height={20}
            width={15}
            alt="pin"
            className="inline"
          />
          <span>Your location</span>
        </span>
        <span className="">
          <span>
            <input
              placeholder="search products..."
              className="w-[77%] h-full border-none"
            ></input>
          </span>
          <span className="bg-primaryg h-fit w-fit">
            <Image
              src={"search.svg"}
              height={20}
              width={25}
              alt="pin"
              className="inline"
            />
          </span>
        </span>
      </div>
      <div>
        <span>
          <span className="p-1">
            <Image
              src={"cart.svg"}
              height={15}
              width={20}
              alt="pin"
              className="inline"
            />
          </span>
          <span>Cart</span>
        </span>
        <span>
          <span className="p-1">
            <Image
              src={"person.svg"}
              height={15}
              width={20}
              alt="pin"
              className="inline"
            />
          </span>
          <span>My Account</span>
        </span>
      </div>
    </div>
  );
}
