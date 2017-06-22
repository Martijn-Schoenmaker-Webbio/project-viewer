* {
  box-sizing: border-box;
}

body {
  font-family: Arial;
}

a {
  text-decoration: none;
}

a, a:active, a:focus {
  color: #343434;
}

 a:hover {
   color: #d9252e;
 }

li {
  list-style: none;
  margin-bottom: 10px;
}

li.activeLink a {
  color: #d9252e;
}

img {
  vertical-align: middle;
}

.menu {
  box-sizing: border-box;
  width: 300px;
  padding: 0 20px;
  background: #eee;
  position: fixed;
  border-left: 1px solid #cacaca;
  right: -300px;
  top: 0;
  height: 100%;
  -webkit-transition: all 0.3s ease-out;
   -moz-transition: all 0.3s ease-out;
    -ms-transition: all 0.3s ease-out;
     -o-transition: all 0.3s ease-out;
        transition: all 0.3s ease-out;
}

.menu-stay {
  right: 0;
  -webkit-transition: all 0s ease-out;
   -moz-transition: all 0s ease-out;
    -ms-transition: all 0s ease-out;
     -o-transition: all 0s ease-out;
        transition: none;
}

.menu-out {
  right: 0;
}

.fold {
  position: fixed;
  border-bottom: 2px dashed #219CE6;
  display: none;
}

.btn-menu {
  z-index: 11;
  padding: 1px 20px;
  height: 32px;
  border-radius: 4px 4px 0px 0px;
  background: #272727;
  border-top: 2px solid #464646;
  color: white;
  position: fixed;
  bottom: 0;
  right: 150px;
  cursor: pointer;
  font-size: 12px;
  -webkit-transition: background-color 0.2s ease-in-out;
   -moz-transition: background-color 0.2s ease-in-out;
    -ms-transition: background-color 0.2s ease-in-out;
     -o-transition: background-color 0.2s ease-in-out;
        transition: background-color 0.2s ease-in-out;
}

.btn-menu p {
  margin: 9px;
}

a img {
  width: 50px;
}

.btn-menu:hover {
  height: 35px;
  background: #191919;
}

.bottom-buttons {
  position: absolute;
  bottom: 50px;
  width: 260px;
}

.width-changer {
  font-size: 0;
}

.fold-changer {
  border: 1px solid #bbbbbb;
  border-radius: 2px;
  padding: 5px;
  text-align: center;
  font-size: 12px;
  margin-bottom: 10px;
  cursor: pointer;
}

.fold-changer:hover {
  background: white;
}

.width-changer a {
  display: inline-block;
}

svg {
  width: 50px;
}

.resize-buttons {
  width: 50%;
  display: inline-block;
  text-align: center;
  /*background: #d9252e;*/
  padding: 20px 0 20px 0;
  /*border: 1px solid #d9252e;*/
  border: 1px solid #bbbbbb;
}

.resize-buttons:hover {
  background: white;
  cursor: pointer;
}

.resize-buttons:hover svg {
  fill:#d9252e;
}

.left {
  border-bottom-left-radius: 2px;
  border-top-left-radius: 2px;
  border-right: 0;
}

.right {
  border-bottom-right-radius: 2px;
  border-top-right-radius: 2px;
}

.active {
  background: white;
  color: #d9252e;
}

.active svg {
  fill: #d9252e;
}
