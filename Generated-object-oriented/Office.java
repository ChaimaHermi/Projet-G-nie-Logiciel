/***********************************************************************
 * Module:  Office.java
 * Author:  ayeta
 * Purpose: Defines the Class Office
 ***********************************************************************/

import java.util.*;

/** @pdOid 9857edc2-0578-42d1-bf4b-76d09f557aba */
public class Office {
   /** @pdOid 2e2d4d5c-6aae-4cad-a1c8-e04f6e73d16d */
   private String image;
   /** @pdOid 3860dbab-0e00-4161-bb3f-e958ce8b4b0a */
   private String name;
   /** @pdOid 29090e34-9e71-455a-95a0-8323fc8e659d */
   private String reference;
   /** @pdOid 37f4939f-85b6-469f-89e6-8f1cea7e51cc */
   private String description;
   
   /** @pdRoleInfo migr=no name=Office_type assc=Association_9 coll=java.util.Collection impl=java.util.HashSet mult=1..1 */
   public Office_type office_type;

}