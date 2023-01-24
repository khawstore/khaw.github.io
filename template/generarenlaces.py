folder = ["hpaio", "adata", "acer", "asus", "dell", "gateway", "gigabyte", "hdc", "hp", "lenovo", "msi", "microsoft", "toshiba"]
limit = [4, 6, 14, 32, 44, 49, 50, 51, 95, 113, 122, 123, 124]
cont = 0
cont2 = 1

for i in range (125):
    if cont < 10:
        if i < limit[cont]:
            str1 = "update laptop set img = '0"+ str(cont) +"."+folder[cont]+"/"+str(cont2)+".png' where idLAPTOP = "+str(i+1)+";"
            cont2 += 1
            print(str1)
        else:
            str1 = "update laptop set img = '0"+ str(cont) +"."+folder[cont]+"/"+str(cont2)+".png' where idLAPTOP = "+str(i+1)+";"
            print(str1)
            cont += 1
            cont2 = 1
    else:
        if i < limit[cont]:
            str1 = "update laptop set img = '"+ str(cont) +"."+folder[cont]+"/"+str(cont2)+".png' where idLAPTOP = "+str(i+1)+";"
            cont2 += 1
            print(str1)
        else:
            str1 = "update laptop set img = '"+ str(cont) +"."+folder[cont]+"/"+str(cont2)+".png' where idLAPTOP = "+str(i+1)+";"
            print(str1)
            cont += 1
            cont2 = 1
            


