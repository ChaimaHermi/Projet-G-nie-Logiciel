/***********************************************************************
 * Module:  Building.java
 * Author:  ayeta
 * Purpose: Defines the Class Building
 ***********************************************************************/

import java.util.*;

/** @pdOid a5892ebd-0a03-4fb2-8281-9e2c2880bcf4 */
public class Building {
   /** @pdOid c09dcfc2-e462-44d0-9453-555172d4d621 */
   private String name;
   /** @pdOid 3b9f99fd-b8fc-45d5-80c6-3ffab13921c9 */
   private String description;
   /** @pdOid c9d4a16f-1206-40aa-84f1-64f0de5729d6 */
   private String reference;
   /** @pdOid 77e1e3f7-cfdd-4dba-a1dd-c04b460bb962 */
   private String image;
   /** @pdOid 5b2481a9-15e4-4bd9-8b82-af531e398888 */
   private String address;
   /** @pdOid 1bb7c986-6977-4fdf-8757-8cf104d047e0 */
   private double longitude;
   /** @pdOid 7e602ab5-18a7-419d-9566-29b3dc526576 */
   private double latitude;
   
   /** @pdRoleInfo migr=no name=Section assc=Association_12 coll=java.util.Collection impl=java.util.HashSet mult=1..* type=Composition */
   public java.util.Collection<Section> section;
   
   
   /** @pdGenerated default getter */
   public java.util.Collection<Section> getSection() {
      if (section == null)
         section = new java.util.HashSet<Section>();
      return section;
   }
   
   /** @pdGenerated default iterator getter */
   public java.util.Iterator getIteratorSection() {
      if (section == null)
         section = new java.util.HashSet<Section>();
      return section.iterator();
   }
   
   /** @pdGenerated default setter
     * @param newSection */
   public void setSection(java.util.Collection<Section> newSection) {
      removeAllSection();
      for (java.util.Iterator iter = newSection.iterator(); iter.hasNext();)
         addSection((Section)iter.next());
   }
   
   /** @pdGenerated default add
     * @param newSection */
   public void addSection(Section newSection) {
      if (newSection == null)
         return;
      if (this.section == null)
         this.section = new java.util.HashSet<Section>();
      if (!this.section.contains(newSection))
         this.section.add(newSection);
   }
   
   /** @pdGenerated default remove
     * @param oldSection */
   public void removeSection(Section oldSection) {
      if (oldSection == null)
         return;
      if (this.section != null)
         if (this.section.contains(oldSection))
            this.section.remove(oldSection);
   }
   
   /** @pdGenerated default removeAll */
   public void removeAllSection() {
      if (section != null)
         section.clear();
   }

}