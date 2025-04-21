/***********************************************************************
 * Module:  Section.java
 * Author:  ayeta
 * Purpose: Defines the Class Section
 ***********************************************************************/

import java.util.*;

/** @pdOid b5057537-ee93-4528-af06-aaef7b3e7d94 */
public class Section {
   /** @pdOid 1cbb79a4-26e5-4031-8b6b-f648897fb190 */
   private String name;
   /** @pdOid c49387f3-6e9c-4f9e-b428-664211a73a52 */
   private String description;
   /** @pdOid 6db0ec10-edb5-4a89-bcec-e3fdfd8808f3 */
   private String reference;
   /** @pdOid d7e9e2bf-9003-4ff8-a66d-3dcf1c95880e */
   private String image;
   /** @pdOid aab054e9-3ff8-44c6-bd9c-cee3410a08c0 */
   private String address;
   /** @pdOid 8fd5d630-901f-4f20-b49f-267d3e054688 */
   private double longitude;
   /** @pdOid 387345b6-ee31-46e5-a29b-f175ca04c6c6 */
   private double latitude;
   
   /** @pdRoleInfo migr=no name=Office assc=Association_11 coll=java.util.Collection impl=java.util.HashSet mult=1..* type=Composition */
   public java.util.Collection<Office> office;
   
   
   /** @pdGenerated default getter */
   public java.util.Collection<Office> getOffice() {
      if (office == null)
         office = new java.util.HashSet<Office>();
      return office;
   }
   
   /** @pdGenerated default iterator getter */
   public java.util.Iterator getIteratorOffice() {
      if (office == null)
         office = new java.util.HashSet<Office>();
      return office.iterator();
   }
   
   /** @pdGenerated default setter
     * @param newOffice */
   public void setOffice(java.util.Collection<Office> newOffice) {
      removeAllOffice();
      for (java.util.Iterator iter = newOffice.iterator(); iter.hasNext();)
         addOffice((Office)iter.next());
   }
   
   /** @pdGenerated default add
     * @param newOffice */
   public void addOffice(Office newOffice) {
      if (newOffice == null)
         return;
      if (this.office == null)
         this.office = new java.util.HashSet<Office>();
      if (!this.office.contains(newOffice))
         this.office.add(newOffice);
   }
   
   /** @pdGenerated default remove
     * @param oldOffice */
   public void removeOffice(Office oldOffice) {
      if (oldOffice == null)
         return;
      if (this.office != null)
         if (this.office.contains(oldOffice))
            this.office.remove(oldOffice);
   }
   
   /** @pdGenerated default removeAll */
   public void removeAllOffice() {
      if (office != null)
         office.clear();
   }

}